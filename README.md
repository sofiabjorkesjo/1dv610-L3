How to install?
You need to create a UserData.php file in the model folder. In that file you need to create a class named UserData. You need to create two private variables, 
and then create two public methods for each variable. This methods should be named rightUsername() and rightPassword(). In the methods you set and return the right password and username. This file is not in github.

How to test?
You can test the application by visit: http://1dv610-l3.000webhostapp.com/

What is implemented or not?
Succesful registration and succesful log in with newly registered user is not implemented. 
Manipulated cookie, Stop session hijacking and temporary cookie password is not implemented.
Everything else in the test cases is implemented.
I have implemented a guest book as extra functionality.

Use case for my implemented functionality
Use case: "See and add text to guestbook"
-Starts when user is not logged in and click on the link to see guest book.
-Output: User can se the guest book and a text that says "You need to be logged in to add a text to the guest book!".

Alternative senario:
-Starts when user is logged in.
-User can add a text to the guest book.
-Output: Message "The text is saved in the guest book!"
-User click on the link to see the guest book.
-Output: User can se the guest book.