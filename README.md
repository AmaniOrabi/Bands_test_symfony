# QualiproBackend

This project is built with **Symfony 6.4.18** and **PHP 8.1.2**. It provides a RESTful API for managing and fetching data related to musical bands.

## Features

- Create, read, update, and delete band data via a RESTful API.
- Endpoints for retrieving a list of bands, details of a specific band, and modifying their data.

## Technologies Used

- **Backend Framework**: Symfony 6.4.18
- **PHP**: v8.1.2
- **Database**: MySQL

## API Endpoints

### **1. Get all bands**
- **Route**: `GET /api/bands`
- **Description**: Retrieves a list of all musical bands stored in the database.
  
### **2. Get a specific band**
- **Route**: `GET /api/bands/{id}`
- **Description**: Retrieves detailed information about a specific band by its `id`.

### **3. Create a new band**
- **Route**: `POST /api/bands`
- **Description**: Adds a new band to the database. Requires the following data in the request body:
  - `name`
  - `origin`
  - `city`
  - `startYear`
  - `separationYear`
  - `founders`
  - `members`
  - `musicalStyle`
  - `presentation`

### **4. Update an existing band**
- **Route**: `PUT /api/bands/{id}`
- **Description**: Updates the data of a specific band. The request body can include any of the fields above.

### **5. Delete a band**
- **Route**: `DELETE /api/bands/{id}`
- **Description**: Deletes the specified band from the database.

## Installation

1. Clone the repository:

   ```bash
   git clone <REPOSITORY_URL>
   cd qualipro-backend
