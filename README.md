> **Web-Based** **Conference** **Day** **Management** **System**
> **ReadMe** **File**
>
> **Name:**A.P.Y.R. Kalhara

**1\|** P a g e

> **Conference** **Management** **System** **-Setup** **Instructions**

This guide provides step-by-step instructions to set up and run the
**Conference** **Management** **System**on your localenvironment using
XAMPP or WAMP.

**Prerequisites**

1\. **XAMPP**or**WAMP**installed on your system.

> -\[Download XAMPP\](https://www.apachefriends.org/index.html)
>
> -\[Download WAMP\](https://www.wampserver.com/)

2\. A web browser (e.g., Chrome, Firefox, or Edge).

**Setup** **Instructions**

**Step** **1**: Download and Copy the Web Folder

> 1\. Download the project files as a \`.zip\` file or clone the
> repository:
>
> 1\. Extract or locate the**web**folder in the project.
>
> 2\. Copy the **web**folder into:
>
> o htdocs directory if you're using**XAMPP**(e.g., C:\xampp\htdocs).
>
> o wwwdirectory if you're using**WAMP**(e.g., C:\wamp\www).

**Step** **2:** Start Your WebServer

> 1\. Open **XAMPP** **Control** **Panel**or**WAMP**.
>
> 2\. Start the following services:
>
> o **MySQL**:For the database.

**2\|** P a g e

**Step** **3:** Create the Database

> 1\. Open your web browser.
>
> 2\. Navigate to the**createdatabase**.**php**script:
>
> • [**<u>http://localhost/\<foldername\>/cratedatabase.php</u>**](http://localhost/web/cratedatabase.php)
>
> 3\. This script will automatically:
>
> • Create the database named conference.
>
> • Create all required tables (users, sessions, myssion, file).
> • Insert sample session data into the sessions table.
>
> 4\. Verify the success messages inyour browser to ensure the database
> setupis complete.

**Step** **4:** Launch the Application

> 1\. Navigate to the main.html file in your browser:
>
> • **<u>http://localhost/\<foldername\>/main.html</u>**
>
> 2\. The application interface will load, andyou can start using the
> system.

**Notes**

> • If you encounter any issues:
>
> • Ensure **XAMPP**or **WAMP**is running.
>
> • Verify that the web folder is correctly placed in the htdocs or www
> directory.
>
> • Check your MySQLcredentials in the createdatabase.php file if the
> database creation fails.

**3\|** P a g e

> **Features** **Implemented**

**1.** **Participant** **Features**

> • **Digital** **Registration**: Online registrationwith QR code
> generation for entry.
>
> • **Conference** **Dashboard**: Access schedules, keynote details, and
> session info.
>
> • **Session** **Registration**: Register for sessions and check in via
> QR code.

**2.** **Admin** **Features**

> • **Track** **&** **Session** **Management**: Define tracks/sessions
> andmonitor registrations.
>
> • **ProceedingsSharing**: Upload and share downloadable conference
> materials.

**4.** **TechnicalFeatures**

> • **Automated** **Database** **Setup**:Creates tables andpreloads
> sample data.

**4\|** P a g e
