**- Orphan Data Management Application -**

**Application Description**

This orphan data management application is developed using pure PHP, CSS, and JavaScript. Its primary purpose is to facilitate the management of orphan beneficiaries by allowing administrators to register new beneficiaries and store relevant information.

**Features**

The application includes the following features:

* **Data Collection:** 
  - Personal details (name, gender, date of birth, city, etc.)
  - Identification details
  - Stay information at the center (arrival date, room number)
  - Optional description field
  - Parent information (name, date of birth, city, contact details, identification)
  - Educational details (school name, level, adaptation status, grades)
  - Financial aid information (bursary amount, tutoring details)
  - Health information (medical condition, description)

* **Profile Pictures:**
  - Upload profile pictures for beneficiaries

* **User Interface:**
  - Utilizes Bootstrap for a responsive and user-friendly interface

**Requirements**

Ensure the following prerequisites are met before installing the application:

* PHP server
* MySQL database

**Installation Instructions**

Follow these steps for a successful installation:

1. Clone or download the application files to your web server.
2. Create a database on your MySQL server and import the necessary tables (included in the application files).
3. Configure the `conn.php` file with your database connection details.
4. Upload the application files to your web server's document root.

**Usage**

To use the application, follow these steps:

1. Log in as an administrator using the designated login page.
2. Navigate to the "Remplir Le Formulaire" (Fill the Form) page to register new beneficiaries.
3. Complete the beneficiary information form and optionally upload a profile picture.
4. Click "Enregistrer le profil" (Save Profile) to submit the information.

**Notes**

* The application is written in French.
* The code is enterprise-specific and may require modifications for wider use. Be sure to review and modify as needed for your specific requirements.
