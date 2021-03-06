# Configuration

Overriding the regular entity class

    contractor:
        db_driver: orm driver use

        factory_vacation: App\Vacation\Factory\VacationFactory - factory for creating Vacation objects, missing values can be resolved at the Mediator level or by overriding the factory
        entity_vacation: App\Vacation\Entity\Vacation - overriding entity class
        dto_vacation: App\Vacation\Dto\VacationDto - the dto class the entity is working with
        entity_user: References on Real User for example App\Entity\User
        constraints_vacation: enable/disable predefined constrains
        decorates:
            command_vacation: custom command decorator
            query_vacation: custom query decorator

# CQRS model

Actions in the controller are split into two groups
creating, editing, deleting data

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)

data retrieval

        2. getAction(GET), criteriaAction(GET)

each method works with its own manager

        1. CommandManagerInterface
        2. QueryManagerInterface

When overriding the standard entity class, data addition is performed by decoration using MediatorInterface

serialization groups

    1. api_get_vacation - get vacation
    2. api_post_vacation - create vacation
    3. api_put_vacation - edit vacation

# Status:

    VACATION
    
    create:
        entity vacation created HTTP_CREATED 201
    update:
        entity vacation updated HTTP_OK 200
    delete:
        entity vacation deleted HTTP_ACCEPTED 202
    get:
        entity vacation fine HTTP_OK 200
    errors:
        if vacation is not found VacationNotFoundException returns HTTP_NOT_FOUND 404
        if vacation is not unique UniqueConstraintViolationException returns HTTP_CONFLICT 409
        if vacation fails the validation VacationInvalidException returns HTTP_UNPROCESSABLE_ENTITY 422
        if vacations cannot be saved VacationCannotBeSavedException returns HTTP_NOT_IMPLEMENTED 501
        all other errors are returned as HTTP_BAD_REQUEST 400

# Test:

    composer install --dev
    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity



