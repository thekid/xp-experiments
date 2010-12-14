/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package net.xp_framework.xararchiver;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import net.xp_framework.xar.XarEntry;
import net.xp_framework.xar.XarFile;
import org.codehaus.plexus.archiver.AbstractArchiver;
import org.codehaus.plexus.archiver.ArchiveEntry;
import org.codehaus.plexus.archiver.ArchiverException;
import org.codehaus.plexus.archiver.ResourceIterator;
import org.codehaus.plexus.components.io.resources.PlexusIoResource;

/**
 *
 * @author kiesel
 */
public class XarArchiver extends AbstractArchiver {
    private File xarFile    = null;
    private XarFile xar  = null;

    protected String getArchiveType() {
        return "xar";
    }

    protected void close() throws IOException {
        throw new UnsupportedOperationException("Not supported yet.");
    }

    protected void execute() throws ArchiverException, IOException {
        ResourceIterator i= this.getResources();

        if (!i.hasNext()) throw new ArchiverException("You must at least include one file.");

        xarFile= this.getDestFile();
        if (null == xarFile) throw new ArchiverException("You must set the destination file.");
        this.initializeXar();

        this.getLogger().info("Updating xar: " + xarFile.getName());
        while (i.hasNext()) {
            ArchiveEntry ae= i.next();
            this.getLogger().debug("Have resource: " + ae);

            this.addResource(ae);
        }

        this.writeXar();
    }

    private void initializeXar() {
        this.xar= new XarFile();
    }

    private void addResource(ArchiveEntry ae) throws IOException {
        String id= ae.getName();
        id.replace(File.separatorChar, '/');

        // Cannot add an empty named element
        if ("".equals(id)) return;

        // .xar archives cannot contain directories
        if (ae.getResource().isDirectory()) return;

        this.addFile(id, ae);
    }

    private void addFile(String id, ArchiveEntry ae) throws IOException {
        PlexusIoResource r= ae.getResource();
        InputStream is= r.getContents();

        byte[] transfer= new byte[8192];
        ByteArrayOutputStream ba= new ByteArrayOutputStream();
        while (is.available() > 0) {
            int l= is.read(transfer);
            ba.write(transfer, 0, l);
        }

        this.xar.add(new XarEntry(id, ba.toByteArray()));
    }

    private void writeXar() throws IOException {
        this.xarFile.createNewFile();
        FileOutputStream fos= new FileOutputStream(this.xarFile);

        this.xar.write(fos);

        fos.close();
    }
}
