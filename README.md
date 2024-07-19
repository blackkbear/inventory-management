# Context
This web application was created to complete my graduation project so that I could achieve my bachelor's degree in Computer Science. This project only used free and open-source technologies that could help solve the problematic situation that was facing the Dental Clinic "DentoSalud" at the time by optimizing by 80% their inventory management, since it automates how they control their inventory, making the process efficient by reducing human resources, time invested, and the margin of errors. 

## What does it do?

This project contains modules such as login, create/read/update/delete users, create/read/update/delete inventory or products, create/read/update/delete categories, and create/read/delete orders. There's also a module called "Alerts" which notifies when a specific product based on certain validations needs to be restocked soon or is completely out of stock.

The **login** module works with user roles and permissions, only those who have an existing user can log in, otherwise, an admin must create or recover your account.

The **user** module also works with user roles and permissions, only admins can perform any RWX action on this module, regular users don't have these privileges, and can only read the information.

The **inventory** module has a filter functionality that will fetch any product within the selected category that's being searched, once the filter is no longer needed, the clean button will remove the filter. This module allows the creation, update, and deletion of a product, and also has an entry/exit control of a product's quantity.

The **category** module allows for the creation, reading, updating, and deletion of categories. If a category has multiple existing products assigned to it and you want to delete the category, a validation will prompt you to be cautious with this action. Once approved, all products associated with the category will be deleted in a cascading manner.

The **shopping list** has different sections:
  - **Create list to order**: This section allows users to create an array/list of different products that need to be ordered. First, there will be a filter that will search for products within the selected category, then a quantity for the desired product must be entered, and then it should be added to the list. Once all wanted products are listed, a description for this list must be entered, and finally, the list can be created, and will pass to be an "order in process".
    
  - **Orders in process**: In this section general information will be shown in a table, such as order/list number, it will capture the session of the user who created the list, and it will also capture the system's time of when this list was created, the list's description. Finally, there will be different actions to take with this list, you can change the status of this list to complete it and once it's complete it'll pass to the order's history section, you can also generate a PDF capturing the general, and detailed information of the shopping's list, or, this list can be permanently deleted from the system. How this section typically works is that once you've printed or saved the PDF, this can be passed on to a third-party provider, and once the items arrive at the business, you'd check this list and complete it.
    
  - **Order's history**: In this section, all completed lists will remain historical in the application's database, a PDF can be generated to look back at what was ordered, or this list can be permanently deleted, as well.

Each module includes various input validations to prevent system errors, injections, or incorrect manipulations. These validations ensure that any expected errors are displayed on the page.

## Technologies

The web application uses these technologies because, due to my college graduation project requirements, it had to be a completely free system for the company without paid technologies or services. However, it is scalable. It's already created with a user web interface that provides simple navigation and management, and it is fully ready to be uploaded to a cloud server. The technologies and processes used were the following:

### Back-End
  - Project created with Visual Studio Code using MVC for modular development for easy maintenance.
  - Logic, controllers, data consultation/extraction, and functionalities were done with PHP.
  - XAMPP hosted the project locally which allowed development, making it ready to be deployed to a live cloud server.

### Front-End 
  - HTML/CSS were used to provide styling to the interface.
  - JavaScript was used to provide dynamic interactions to buttons.
  - BootStrap provided predesigned components and styling that enhanced the interface.

### Database
  - MySQL was used to manage the application's data.
  - phpMyAdmin worked as my MySQL database manager.

### Others
  - SCRUM was the agile methodology used for planning and task management.
  - SQL and back-end validations were implemented to prevent SQL injection attacks, and also validate user inputs.

The phases that involved the development of this project were:
1. Analysis: Gathered requirements from the customer to better understand the client's needs and expectations. With the requirements, I've started to design the use cases, general diagram of the use cases, classes diagram, sequence diagram, entity and relational diagram, and data dictionary. This allowed me to understand the functionalities, attributes, relations, interactions, architecture, and structure that the program must have.
2. Design: Designed mockups or prototypes of each screen that the web application would have, to have the customer's approval, before starting the development phase.
3. Development: Developed the database, back-end modules, and front-end, and created test scenarios to test the workflow and user interaction of each module. 
4. Implementation: Created the user's manual and demo, and signed off the deployment of the web application in the client's machine.

## Demo

https://github.com/user-attachments/assets/6a3707dc-ccbc-4e55-b12f-13f1ad12a9d7

## Simple system navigation

![image](https://github.com/user-attachments/assets/16919593-b522-469c-bc82-737706362523)

![image](https://github.com/user-attachments/assets/9d6c16f6-8d74-41e4-919c-81366eb27943)

![image](https://github.com/user-attachments/assets/b2457124-0415-4992-a4c8-ced810fec349)

![image](https://github.com/user-attachments/assets/5f920767-0af7-4789-91a6-cb18df971b24)

![image](https://github.com/user-attachments/assets/7b401ef6-2202-4329-9535-863bca640ccc)

![image](https://github.com/user-attachments/assets/06ae3a00-02f7-4e58-b374-33ac758866b1)

![image](https://github.com/user-attachments/assets/fad7d1a1-ecbd-4963-a4fc-53fcfb16704c)

![image](https://github.com/user-attachments/assets/caa907be-0e2f-4143-afda-526aba7aafdf)


