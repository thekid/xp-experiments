package net.xp_framework;

import org.apache.maven.artifact.DependencyResolutionRequiredException;
import org.apache.maven.plugin.AbstractMojo;
import org.apache.maven.plugin.MojoExecutionException;
import org.codehaus.plexus.util.DirectoryWalkListener;
import org.codehaus.plexus.util.DirectoryWalker;
import java.io.File;
import java.util.ArrayList;
import java.util.Iterator;
import org.apache.maven.project.MavenProject;

import org.codehaus.plexus.util.cli.CommandLineException;
import org.codehaus.plexus.util.cli.CommandLineUtils;
import org.codehaus.plexus.util.cli.Commandline;
import org.codehaus.plexus.util.cli.StreamConsumer;

import java.util.List;

/**
 * Goal which touches a timestamp file.
 *
 * @requiresDependencyResolution test
 * @goal xp-unittest
 */
public class UnittestMojo extends AbstractMojo implements DirectoryWalkListener {

    /**
     * Set test path elements
     *
     * @parameter expression="${project.compileSourceRoots}"
	 * @required
	 * @readonly
     */
	private List<String> testPathElements;

	/**
	 * @parameter expression="${project.build.testSourceDirectory}"
	 * @required
	 */
	private String testSourceDirectory;

	/**
	 * @parameter expression="${project}"
	 * @required
	 */
	protected MavenProject project;

	/**
	 * @parameter
	 */
	public String[] includes;

	/**
	 * @parameter
	 */
	public String[] excludes;

	private List<String> testCaseFiles= new ArrayList<String>();

    public void execute() throws MojoExecutionException {
  		this.getLog().info("Running XP unittest...");
		this.project.addTestCompileSourceRoot(this.testSourceDirectory);

		// Scan for test cases
		DirectoryWalker walker= new DirectoryWalker();
		walker.setBaseDir(new File(this.testSourceDirectory));
		walker.addDirectoryWalkListener(this);
		walker.addSCMExcludes();

		this.getLog().debug("Includes= " + this.includes + "; excludes= " + this.excludes);
		if (this.includes != null) { for (String i : this.includes) { walker.addInclude(i); }}
		if (this.excludes != null) { for (String e : this.excludes) { walker.addExclude(e); }}
		
		walker.scan();

		// After having found test cases, invoke them!
		Commandline cli= new Commandline("unittest");
		try {
			// Build classpaths
			Iterator<String> i= this.project.getTestClasspathElements().iterator();
			StringBuilder cp= new StringBuilder(1024);
			while (i.hasNext()) {
				cp.append(i.next());
				if (i.hasNext()) {
					cp.append(':');
				}
			}
			
			cli.addArguments(new String[] { "-cp", cp.toString() });
		} catch (DependencyResolutionRequiredException ex) {
			this.getLog().error(ex);
		}

		String[] s= new String[this.testCaseFiles.size()];
		s= this.testCaseFiles.toArray(s);
		cli.addArguments(s);
		this.getLog().debug("Invoking command line: " + cli);

		int exitValue= -1;
		try {
			exitValue= CommandLineUtils.executeCommandLine(cli,
					new StreamConsumer() {
						public void consumeLine(String string) {
							getLog().info("> " + string);
						}
					},
					new StreamConsumer() {
						public void consumeLine(String string) {
							getLog().error("> " + string);
						}
					}
					);
			cli.execute();
		} catch (CommandLineException ex) {
			this.getLog().error(ex);
		}

		if (exitValue != 0) {
			throw new MojoExecutionException("Unittest(s) failed.");
		}
    }

	public void directoryWalkStarting(File file) {
		this.getLog().debug("===> Starting at " + file);
	}

	public void directoryWalkStep(int i, File file) {
		if (file.isFile()) {
			this.testCaseFiles.add(file.getAbsolutePath());
		}
		this.getLog().debug("---> Step " + i + " at " + file);
	}

	public void directoryWalkFinished() {
		this.getLog().debug("---> Finished");
	}

	public void debug(String string) {
		this.getLog().debug("---> Debug: " + string);
	}
}
