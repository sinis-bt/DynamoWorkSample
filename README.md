# Nobel Laureates API Endpoint (PHP Slim Framework)

This repository contains a PHP implementation of an API endpoint using the Slim Framework, designed to fetch and present information about Nobel laureates.

## Functionality

- **Fetch from Open API:** The endpoint retrieves Nobel laureate data from the open API.
- **JSON Parsing:** The retrieved JSON response is parsed to extract relevant information.
- **Sorting by Date Awarded:** Laureates are sorted in descending order based on the date they were awarded.
- **Limiting to Recent 20 Laureates:** The list is limited to the most recent 20 laureates to ensure a concise and relevant output.
- **JSON Output Format:** The endpoint outputs a JSON response with the following fields for each laureate, presented in English:
  - Full name
  - Birth date
  - Native country
  - Category
  - Date awarded

## PHP Slim Framework

This project utilizes the PHP Slim Framework for building a lightweight and efficient API endpoint. The framework provides a clear and structured interface for retrieving Nobel laureate data.

## Getting Started

To use this project, follow these steps:

1. Clone the repository to your local machine.

   ```bash
   git clone git@github.com:sinis-bt/DynamoWorkSample.git
   
2. composer install

   ```bash
   docker compose -f ./docker-compose.yml -p dynamoworksample up -d --build slim
