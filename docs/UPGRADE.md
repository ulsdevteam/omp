# Upgrading an OMP Installation

Note: Before upgrading your installation, perform a complete backup of your
data files and database. If the upgrade process fails, you will need to recover
from backup before continuing.

If you are using PHP Safe Mode, please ensure that the max_execution_time
directive in your php.ini configuration file is set to a high limit. If this
or any other time limit (e.g. Apache's "Timeout" directive) is reached and
the upgrade process is interrupted, manual intervention will be required.

Upgrading to the latest version of OMP involves two steps:

- [Obtaining the latest OMP code](#obtaining-the-latest-ojs-code)
- [Upgrading the OMP database](#upgrading-the-ojs-database)

It is highly recommended that you also review the release notes ([docs/RELEASE](RELEASE))
and other documentation in the docs directory before performing an upgrade.


### Obtaining the latest OMP code

The OMP source code is available in two forms: a complete stand-alone 
package, and from read-only github access.

#### 1. Full Package

If you have not made local code modifications to the system, upgrade by 
downloading the complete package for the latest release of OMP:

- Download and decompress the package from the OMP web site into an empty
	directory (NOT over top of your current OMP installation)
- Move or copy the following files and directories into it from your current
	OMP installation:
		- config.inc.php
		- public/
		- Your uploaded files directory ("files_dir" in config.inc.php), if it
			resides within your OMP directory
- Synchronize new changes from config.TEMPLATE.inc.php to config.inc.php
- Replace the current OMP directory with the new OMP directory, moving the
	old one to a safe location as a backup
- Be sure to review the Configuration Changes section of the release notes
	in docs/release-notes/README-(version) for all versions between your
	original version and the new version. You may need to manually add
	new items to your config.inc.php file.


#### 2. git

Updating from github is the recommended approach if you have made local
modifications to the system.

If your instance of OMP was checked out from github (see [docs/README-GIT](README-GIT)),
you can update the OMP code using a git client.

##### Rebasing your local changes on the updated code

To update the OMP code from a git check-out, run the following command from
your OMP directory:

```
$ git rebase --onto <new-release-tag> <previous-release-tag>
```

This assumes that you have made local changes and committed them on top of
the old release tag. The command will take your custom changes and apply
them on top of the new release. This may cause merge conflicts which have to
be resolved in the usual way, e.g. using a merge tool like kdiff3.

"TAG" should be replaced with the git tag corresponding to the new release.
OMP release version tags are of the form "omp-MAJOR_MINOR_REVSION-BUILD".
For example, the tag for the initial release of OMP 1.0.0 is "omp-1_0_0-0".

Consult the [README](README) of the latest OMP package or the OMP web site for the
tag corresponding to the latest available OMP release.

Note that attempting to update to an unreleased version (e.g., using the HEAD
tag to obtain the bleeding-edge OMP code) is not recommended for anyone other
than OMP or third-party developers; using experimental code on a production
deployment is strongly discouraged and will not be supported in any way by
the OMP team.

##### Update PHP dependencies

To update the PHP dependencies, you have to run
```
composer --working-dir=lib/pkp update
composer --working-dir=plugins/paymethod/paypal update
```

##### Update Javascript libraries and build.js

To update the Javascript libraries and rebuild the build.js you have to run
```
npm install
npm run build
```

### Upgrading the OMP database

After obtaining the latest OMP code, an additional script must be run to
upgrade the OMP database and potentially execute additional upgrade code,
which notably may also manipulate the OMP data files.

NOTE: Patches to the included ADODB library may be required for PostgreSQL
upgrades; see https://forum.pkp.sfu.ca/t/upgrade-failure-postgresql/19215

This script can be executed from the command-line or via the OMP web interface.

#### 1. Command-line

If you have the CLI version of PHP installed (e.g., /usr/bin/php), you can
upgrade the database as follows:

- Edit config.inc.php and change "installed = On" to "installed = Off"
- Run the following command from the OMP directory (not including the $):
	- `$ php tools/upgrade.php upgrade`
	- Because the database upgrade may also write to the filesystem
	(especially `files_dir`), it is important to consider the user
        selected to execute this command.
- Re-edit config.inc.php and change "installed = Off" back to
	 "installed = On"

#### 2. Web

If you do not have the PHP CLI installed, you can also upgrade by running a
web-based script. To do so:

- Edit config.inc.php and change "installed = On" to "installed = Off"
- Open a web browser to your OMP site; you should be redirected to the
	installation and upgrade page
- Select the "Upgrade" link and follow the on-screen instructions
- Re-edit config.inc.php and change "installed = Off" back to
	 "installed = On"
