ldap_server
Overview

The ldap_server project provides a simple solution for creating an LDAP server suitable for an address book in Outlook or any POP3 email client. It utilizes ApacheDS for the backend LDAP server and PHP for managing LDAP entries and interactions.
Functionality
Features:

    Create Organizational Units (OU) or Import from LDIF: Allows for the creation of Organizational Units or the importing of LDIF files to populate the LDAP server's directory structure.

    Creation of LDIF Files: Generates LDIF files containing user information such as email addresses and other details. Automatically creates corresponding entries in the database.

    Import from CSV File: Provides functionality to import user data from CSV files into the LDAP server.

    Download LDIF Files: Enables users to download LDIF files containing LDAP entries for use in tools like Apache Directory Studio.

Installation
Requirements:

    Java SDK: Ensure that the Java Development Kit (JDK) is installed on your system and that the JAVA_HOME environment variable is correctly set.

    ApacheDS: Install and configure ApacheDS to serve as the backend LDAP server. Ensure that no other service is using port number 10389.

    Apache Directory Studio: Install Apache Directory Studio to manage the LDAP server's database and directory structure.

    XAMPP/WAMP: Set up XAMPP or WAMP to assist in LDIF creation and database management.

Installation Steps:

    Install Java SDK: Download and install the Java SDK appropriate for your operating system. Set the JAVA_HOME environment variable to point to the Java installation directory.

    Install ApacheDS: Download and install ApacheDS and create an instance for use as the backend LDAP server.

    Install Apache Directory Studio: Install Apache Directory Studio to connect to the ApacheDS instance and manage the LDAP server's database and directory structure.

    Set Up Database: Create a project in XAMPP or WAMP and configure the database. Create a table to store LDAP entry data, and ensure that the necessary database credentials are configured.

    Configure Project: Modify the project configuration to specify the required database credentials and other settings as needed
