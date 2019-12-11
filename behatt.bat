@ECHO OFF
ECHO Running behat tests..
call C:\Behat\bin\behat --version
call C:\Behat\bin\behat --config behat.yml --format junit --out report.xml
PAUSE