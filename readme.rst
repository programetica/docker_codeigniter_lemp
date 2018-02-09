This is an attempt to use phpdocker.io and IntelliJ to set up a Codeigniter development environment.

It was set up on a Virtualbox (5.2.6) Centos7 virtual machine.  

My IntelliJ information:
IntelliJ IDEA 2017.3.4 (Ultimate Edition)
Build #IU-173.4548.28, built on January 29, 2018
Linux 3.10.0-327.22.2.el7.x86_64

The basics run.  I created three Run/Debug configurations, one using the docker-compose.yaml file generated in phpdocker.io and one each pointed at the created docker image of the php and nginx containers.

I haven't figured out the xdebug configuration yet.

The files include:

*  a SQL file to add a database table and record for testing.
*  images of the IntelliJ configurations I'm trying for xdebug.
