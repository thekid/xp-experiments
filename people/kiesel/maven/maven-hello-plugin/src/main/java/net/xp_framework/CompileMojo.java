package net.xp_framework;

import java.io.File;
import org.apache.maven.plugin.AbstractMojo;
import org.apache.maven.plugin.MojoExecutionException;
import org.apache.maven.plugin.MojoFailureException;
import org.codehaus.plexus.util.DirectoryWalkListener;

/**
 * Goal which touches a timestamp file.
 *
 * @requiresDependencyResolution compile
 * @goal xp-compile
 */
public class CompileMojo extends AbstractMojo implements DirectoryWalkListener {

	public void execute() throws MojoExecutionException, MojoFailureException {
		
	}

	public void directoryWalkStarting(File file) {
		throw new UnsupportedOperationException("Not supported yet.");
	}

	public void directoryWalkStep(int i, File file) {
		throw new UnsupportedOperationException("Not supported yet.");
	}

	public void directoryWalkFinished() {
		throw new UnsupportedOperationException("Not supported yet.");
	}

	public void debug(String string) {
		throw new UnsupportedOperationException("Not supported yet.");
	}

}
