<!-- Improved compatibility of back to top link: See: https://gitlab.duthu.net/S52100852/webud/pull/73 -->
<a name="readme-top"></a>

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://gitlab.duthu.net/S52100852/webud">
    <img src="www/assets/logo.png" alt="Logo" width="" height="">
  </a>

  <h3 align="center">IIEX - Cinema</h3>

  <p align="center">
    Excellent Experience
    <br />
    <a href="https://gitlab.duthu.net/S52100852/webud"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://gitlab.duthu.net/S52100852/webud">View Demo</a>
    ·
    <a href="https://gitlab.duthu.net/S52100852/webud/issues">Report Bug</a>
    ·
    <a href="https://gitlab.duthu.net/S52100852/webud/issues">Request Feature</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project
This is the final report for `WebUD` course

<p align="right">(<a href="#readme-top">back to top</a>)</p>



### Built With

* [![Docker][Docker.com]][Docker-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![JQuery][JQuery.com]][JQuery-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Software Development Principles, Patterns, and Practices
- `Model-View-Controller (MVC)`: The application follows the MVC architectural pattern, with the model representing the data, the view displaying the data, and the controller handling the user's input and updating the model and view accordingly.
- `Dynamic routing` : Dynamic routing refers to the process of mapping URLs to specific code in a PHP application. This allows for more flexible and customizable routing of user requests to different parts of the application.

- `Dynamic layout`: Dynamic layout in PHP refers to the process of creating customizable interface templates at runtime based on data or user actions. This enables web applications to quickly and flexibly respond to user requests, improving user experience.

## Code Structure
The code for the application is organized into the following packages:

- `Docs`: Contains the documentation of project.
- `mysql.data.sql`: Contains sql code to create database.
- `www`: Contains source code of this project.
<!-- GETTING STARTED -->
## Getting Started


### Prerequisites

* docker install: [Docker Engine](https://www.docker.com/products/docker-desktop)

### Installation

1. Run Docker Engine
2. Clone the repo
   ```sh
   git clone https://gitlab.duthu.net/S52100852/webud.git
   ```
3. Enter workspace
   ```sh
   cd webud
   ```
4. Run compose
   ```sh
   docker-compose up -d
   ```
5. Import database: 
- Go to phpMyAdmin at `http://localhost:8888` with username/password: `root/root` and import `data.sql` in `mysql/sql` package.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage
After `Run compose` access to:
* Account (username/password): 
  - Admin: `admin`/`123456`
  - Client: `user`/`123456`
* Web-app:
  - Admin page `http://localhost:8080/?admin`
  - Client page: `http://localhost:8080/?admin`
* phpMyAdmin (acount root/root): `http://localhost:8888`

_For more examples, please refer to the [Documentation](https://gitlab.duthu.net/S52100852/webud)_

<p align="right">(<a href="#readme-top">back to top</a>)</p>


# Project structure:
    

* `mysql`:
    *  `sql`: include `*.sql` file 
	* `data`: database 
* `www`: include source code

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com

[Docker.com]: https://img.shields.io/badge/docker-ffffff?style=for-the-badge&logo=docker&logoColor=blue
[Docker-url]: https://www.docker.com

[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com 
