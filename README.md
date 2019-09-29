# scheduling_system

Installation & Getting Started:
1. Download & install Xampp software for your OS from https://www.apachefriends.org/download.html
2. Note the path of installation.
3. Clone this project repository into path_of_installation/xampp/htdocs directory
4. Open xampp software and start server for Apache and MySQL
5. Goto http://localhost/phpmyadmin and create a database named 'rgs' as this is the name of the database used in the code.
6. Now in the recently created database perform import using 'rgs.sql' file present in the project repo i.e. scheduling_system/rgs.sql
7. Now when your server is up and running and your database is setup you can goto http://localhost/scheduling_system/php in order to access the project.


User Manual - Getting Started:
1. Goto existing IOE Routine timetable.
2. Now classes(CLASS), practical(PRAC), professor(PROF), room(ROOM), subjects(SUB) are considered as our resources.
3. So you need to add all the resources manually at the first time by clicking 'new' button near Resources as well view existing resources by clicking 'show' button. When creating new resource select the type of resource to be created the corresponding fields will be required to be filled in and after filling up the form click on the 'Add' button.
4. Once all the resources are added you need to create relation between the resources like which teacher will teach which class and how many periods he may take in a single day. So for that you need to create a new activity that appear in the home page of IOE_Routine.
5. Creation of any one of the activity lead to appear in four different categories as show in the page.
6. While creating an activity the resources that have already been created by you will appear and can be selected accordingly. Note the 'length' field indicate how many one teacher can teach in one day. Also note that each activity refer to only one day and so if a teacher may teach 3 days taking (2,2,1) periods then you need to add the same activity by changing the value of 'length' field 3 times.
7. After all the resources and activities have been created, you can click on the link 'Generate' that appear on the homepage of IOE_Routine to automatically generate the routine resolving all the conflicts.
8. In order to make changes in the automatically generated routine, click on the 'Tweak' link and you can make changes according to the suggestion mentioned just below the routine table.
9. After the tweak has been made the new routine is automatically saved.

Note: The assignment of room is automated and can't be tweaked. Though it can be modified after exporting the routine to excel from homepage of IOE_Routine. Also note that the practical subjects can be added with in the resource uding subject_name[P] format and activity for practical can be added by filling the form that appear below while on create new activity page.

Changing the availability:
1. Any resource can be made available or not at any period of any day. So in order to make changes to its availability once the resource has been added, click on 'show' button near Resources and then click on any resource that are separated by category and in the next page click on the specific cell to toggle it between available & not available.
2. There you can update information about the resource too.
3. After making changes to availability you need to commit by clicking on 'commit' link that appear once any changes is made to the availability table.
4. Now in order to get new routine according to the availability of resources modified you need to regenerate routine by clicking the 'Generate' button for auto-generation.
