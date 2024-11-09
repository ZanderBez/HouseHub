<!-- Repository Information & Links-->
<br />

<p align="center">
  <img src="https://img.shields.io/github/repo-size/ZanderBez/HouseHub?color=%000000" alt="GitHub repo size">
  <img src="https://img.shields.io/github/watchers/ZanderBez/HouseHub?color=%000000" alt="GitHub watchers">
  <img src="https://img.shields.io/github/languages/count/ZanderBez/HouseHub?color=%000000" alt="GitHub language count">
  <img src="https://img.shields.io/github/languages/code-size/ZanderBez/HouseHub?color=%000000" alt="GitHub code size in bytes">
</p>

<!-- HEADER SECTION -->
<h5 align="center" style="padding:0;margin:0;">Zander Bezuidenhout</h5>
<h5 align="center" style="padding:0;margin:0;">Student Number: [Your Student Number]</h5>
<h6 align="center">[DV 200]</h6>
</br>
<p align="center">
  <a href="https://github.com/ZanderBez/HouseHub">
    <img src="assets/Layer_1.png" alt="Logo">
  </a >
</p>
  
<h3 align="center">HomeHub Real Estate</h3>
<h4 align="center">Web Application</h4>

<p align="center">
  Your dynamic platform for property browsing, bookmarking, and purchasing.<br>
  <a href="https://github.com/ZanderBez/HouseHub"><strong>Explore the docs »</strong></a>
  <br />
  <br />
  <a href="https://drive.google.com/file/d/1hGlat3ccmjpy3amUTrSk7GGyNtUv0dFS/view?usp=sharing">View Demo</a>
  ·
  <a href="https://github.com/ZanderBez/HouseHub/issues">Report Bug</a>
  ·
  <a href="https://github.com/ZanderBez/HouseHub/issues">Request Feature</a>
</p>

<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Project Description](#project-description)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [How to install](#how-to-install)
* [Features and Functionality](#features-and-functionality)
* [Concept Process](#concept-process)
   * [Ideation](#ideation)
   * [Wireframes](#wireframes)
   * [User-flow](#user-flow)
* [Development Process](#development-process)
   * [Implementation Process](#implementation-process)
        * [Highlights](#highlights)
        * [Challenges](#challenges)
   * [Reviews and Testing](#peer-reviews)
        * [Feedback from Reviews](#feedback-from-reviews)
        * [Unit Tests](#unit-tests)
   * [Future Implementation](#future-implementation)
* [Final Outcome](#final-outcome)
    * [Mockups](#mockups)
    * [Video Demonstration](#video-demonstration)
* [Conclusion](#conclusion)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)
* [Acknowledgements](#acknowledgements)

<!--PROJECT DESCRIPTION-->
## About the Project
<!-- header image of project -->
![Logo Screenshot](assets/Layer_1.png)

### Project Description

HomeHub is a real estate web application developed to simplify property browsing and transactions. The platform supports user authentication, agent listings, property reviews, and a built-in mortgage calculator. Administrators can manage property approvals, ensuring a seamless and secure experience for all user roles.

### Built With

[![Php]( https://img.shields.io/badge/PHP-001440?style=for-the-badge&logo=php&logoColor=#777BB4)](https://www.php.net/docs.php)
[![MySQL]( https://img.shields.io/badge/MYSQL-5B5B5B?style=for-the-badge&logo=mysql&logoColor=white)](https://www.php.net/docs.php)
[![HTML5](https://img.shields.io/badge/HTML-e34c26?style=for-the-badge&logo=html5&logoColor=white)](https://html.spec.whatwg.org/multipage/)
[![CSS3](https://img.shields.io/badge/CSS-563d7c?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![Javascript](https://img.shields.io/badge/Javascript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)](https://www.javascript.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![xampp]( https://img.shields.io/badge/xampp-750000?style=for-the-badge&logo=xampp&logoColor=#FB7A24)](https://www.php.net/docs.php)

<!-- GETTING STARTED -->
## Getting Started

The following instructions will guide you through setting up your local copy of the project for development and testing purposes.

### Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) or any local server environment.
- PHP 7.x or later.
- MySQL or MariaDB database.
- Composer (optional for dependency management).

### How to install

1. **Clone the repository**:
    ```bash
    git clone https://github.com/ZanderBez/HouseHub
    ```
2. **Navigate to the project directory**:
    ```bash
    cd real-estate-web-app
    ```
3. **Move the project to your XAMPP `htdocs` folder**:
    ```bash
    mv real-estate-web-app /path/to/xampp/htdocs/
    ```
4. **Set up the database**:
    - Import `real_estate.sql` using phpMyAdmin or the MySQL command line:
      ```bash
      mysql -u root -p real_estate < /path/to/real_estate.sql
      ```
    - Alternatively, create the tables manually using provided SQL queries.
5. **Update database configuration**:
    Modify `database.php`:
    ```php
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "real_estate";
    ```
6. **Start the server**:
    Start Apache and MySQL in XAMPP.
7. **Access the application**:
    Navigate to `http://localhost/real-estate/login.php`.

## Features and Functionality

### Core Features
- **User Authentication**: Register, log in, and manage user accounts.
- **Property Listings**: Detailed views of properties, images, and agent info.
- **Bookmarking**: Save properties for later.
- **Purchasing Properties**: Initiate purchases.
- **Mortgage Calculator**: Estimate monthly payments.
- **Property Reviews**: User feedback on properties.
- **Role-Based Access**: Different views for users, agents, and admins.
- **Agent Profiles**: Contact information and service regions.
- **Property Status**: Real-time updates (Available, Pending, Sold).

<!-- CONCEPT PROCESS -->
## Concept Process

The concept involved creating a platform that connects users, agents, and admins seamlessly, supporting property searches, listings, and transactions.

### Ideation

Brainstorming sessions highlighted the need for user authentication, role-based access, and a mortgage calculator.

### Wireframes

![SignUp Screenshot](assets/signUp.png)
![LogIn Screenshot](assets/LogIn.png)
![Homepage Screenshot](assets/home.png)
![Property Page Screenshot](assets/Property.png)
![Bookmark Page Screenshot](assets/bookmark.png)
![Agent Page Screenshot](assets/agents.png)

### User-flow

Outlined user journeys, detailing paths from account creation to property purchases.

<!-- DEVELOPMENT PROCESS -->
## Development Process

### Implementation Process

* Created a modular structure using PHP for backend logic.
* Integrated MySQL for data storage.
* Designed responsive pages using Bootstrap and custom CSS.

#### Highlights
* Successful implementation of role-based user management.
* Integrated mortgage calculator functionality.

#### Challenges
* Managing complex SQL queries.
* Optimizing image uploads and property detail rendering.

### Reviews & Testing

#### Feedback from Reviews

Peer reviews were conducted with feedback highlighting the user-friendly design and efficient property search feature. Suggestions were made to include additional filtering options and improve the performance of image uploads.

#### Unit Tests

Basic unit tests were conducted to ensure core functionalities like user authentication and property searches were working as expected. Future plans include comprehensive tests for database interactions and user role permissions.

<!-- FUTURE IMPLEMENTATION -->
### Future Implementation

* Add real-time chat for user-agent communication.
* Enhanced property filtering options.
* Implement user profile customization features.

<!-- FINAL OUTCOME -->
## Final Outcome

### Mockups

#### Sign Up Page
![SignUpMock Screenshot](assets/SignUPMockup.png)

#### Log In Page
![LogInMock Screenshot](assets/LogInMockup.png)

#### Home Page
![HomepageMock Screenshot](assets/HomeMockup.png)

#### Details Page
![DetailsPageMock Screenshot](assets/DetailsMockup.png)

#### Properties Page
![PropertiesPageMock Screenshot](assets/PropertyMockup.png)

### Video Demonstration

[View Demonstration](https://drive.google.com/file/d/1hGlat3ccmjpy3amUTrSk7GGyNtUv0dFS/view?usp=sharing)

<!-- CONCLUSION -->
## Conclusion

HomeHub provides an efficient and user-friendly solution for property browsing, bookmarking, and purchases. The platform’s role-based access ensures that all user types have tailored functionalities, making it a comprehensive tool for real estate management.

<!-- ROADMAP -->
## Roadmap

Future updates include:
- Implementing a real-time chat feature.
- Adding more advanced search filters.
- Developing user profile customization options.

See the [open issues](https://github.com/ZanderBez/HouseHub/issues) for a list of proposed features and known issues.

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open-source community so inspiring. Any contributions are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<!-- AUTHORS -->
## Authors

* **Zander Bezuidenhout** - [ZanderBez](https://github.com/ZanderBez)

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact

* **Zander Bezuidenhout** - [bezuidenhoutzander8@gmail.com](mailto:bezuidenhoutzander8@gmail.com)
* **Project Link** - [HomeHub](https://github.com/ZanderBez/HouseHub)

<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements

* [PHP Documentation](https://www.php.net/docs.php)
* [MySQL](https://www.mysql.com/)
* [Bootstrap](https://getbootstrap.com/)
* [OpenWeather API](https://openweathermap.org/)
* [XAMPP](https://www.apachefriends.org/index.html)
* [PHP MyAdmin](https://www.phpmyadmin.net/)
