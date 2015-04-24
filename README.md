This is an example application framework to try and convert to phalcon

This is not ment to be installed in web directory. This is ment to be installed out side the web directory

I have installed this under /opt/laslo

The I created a link in the /var/www/ dir and created a link to /opt/laslo/public called laslo 
ln -s /opt/laslo/public /var/www/laslo

Then I access it via http://<ip>/laslo/

Each sub application has it's own public directory. i was thinking of making links in the laslo/public to the /laslo/app1/public to acess thoes files.
ln -s /opt/laslo/app1/public /opt/laslo/public/app1