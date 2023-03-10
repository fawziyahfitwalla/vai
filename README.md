
## Tech Stack

Laravel Framework 10.3
Bootstrap CDN's 3+ 
jQuery CDN's 3+

## Setup

Run the migrations
Seed the database for admin user
Login using the form
Admin -> add users or patients and book appointments
Users -> register using the registration form or by admin

## Project Details

Although, the project does not involve very complex logics and algorithims, it was a bit time consuming to take care of the minute details. There is no separate directory or routes for the admin, doctor or users as it would have caused a code redundancy keeping in mind the fact there is no vast functionality difference. The code works based upon the session data that stores the user role and is used for authroizing the routes.

My first approach was to make the endpoints for all the functionality and then proceed with the front-end and then the authentication and authorization.

My biggest drawback was my system, which greatly impacted my productivity and increased my working hours. I have an old system, that doesn't support huge softwarres and multitaksing. That was quite a challenge for me to finish the task in the provided timespan on such system. Nevertheless, I am grateful I am able to accomplish majority of it without compromising the quality of code. It would have taken much shorter time, had it not been my system issue.

I am pending few tasks:
1. Captcha Verification
2. Guest Appointment Booking
3. Change Appointment (Although, the backend function is written, I could not create a front-end and complete the functionality)
4. If time would have permitted, I would have integrated the Full Calender View for the appointments view for all the user roles

Completed Tasks:
1. Authentication
2. Authorization based on Session
3. Patient Registration
4. Add Doctor, Patient or Admin - Admin
5. Book Appointments - Admin, Patient
6. Mark the appointments cancelled or completed - Admin, Doctor
7. View User's List
8. View Appointments - Admin can view all appointments, doctor and patient can view just their appointments



