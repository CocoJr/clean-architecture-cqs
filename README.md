# Clean Architecture and CQS Pattern Implementation in Symfony

## Overview

This repository is an example implementation of the Clean Architecture and the Command Query Separation (CQS) pattern in a Symfony application. Clean Architecture is a software design philosophy that separates concerns and enforces a clear division between the application's core business logic, application-specific code, and external dependencies. The CQS pattern emphasizes the separation of commands (actions that change the application's state) and queries (actions that return data without affecting the state).

## Getting Started

To run this project locally, follow these steps:

1. Copy the `.env.dist` file to `.env` and update the values as needed.

2. Start the Docker containers:

```shell
docker-compose up --build -d
```

3. Install project dependencies:

```shell
docker-compose exec app make init
```

4. Access the Symfony application in your browser at:

```shell
http://localhost:<FRONT_PORT>
```
(Use the FRONT_PORT value from your .env file.)

5. Access the RabbitMQ Management UI at:

```shell
http://localhost:<RABBITMQ_PORT>
```
(Use the RABBITMQ_PORT value from your .env file.)

6. To generate code coverage reports, run the following command:

```shell
docker-compose exec app make test-coverage
```
You can view the code coverage results at:

```shell
http://localhost:<FRONT_PORT>/coverage
```

## Architecture Explanation

- **src/Application**: This directory contains the application layer, which includes command and query implementations. It represents the use cases of the application.

- **src/Domain**: The domain layer holds the core business logic. It enforces the separation between business rules and application-specific code.

- **src/Infrastructure**: The infrastructure layer implements the interfaces defined in the application and domain layers. Here, you'll find the code that interacts with external systems and frameworks.

- **tests/Functionals**: These functional tests validate the end-to-end functionality, data integrity, user interactions, external integrations, error handling, and performance of the application.

- **tests/Integrations**: Integration tests focus on testing the use cases of the application and should also avoid mocking the infrastructure layer.

- **tests/Units**: The unit tests ensure the correctness of small, isolated units of code.

Remember, in the Domain layers, we use native PHP, in the Application layer we use the Domain layer as well, while the Infrastructure layer leverages frameworks and external libraries.

This architecture ensures a clean separation of concerns, maintainability, and testability in your application.

## Contributing

Feel free to contribute to this project by opening issues, submitting pull requests, or providing feedback. We welcome collaboration from the community to enhance this example of Clean Architecture and the CQS pattern in Symfony.
