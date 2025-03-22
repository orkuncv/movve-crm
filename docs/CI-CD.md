# Movve CRM CI/CD Pipeline

Dit document beschrijft de Continuous Integration en Continuous Deployment (CI/CD) pipeline voor het Movve CRM project.

## Overzicht

We gebruiken GitHub Actions voor onze CI/CD pipeline. De pipeline bestaat uit twee hoofdonderdelen:

1. **API Tests** - Voert tests uit op de API endpoints bij elke push naar de `main` branch en bij pull requests
2. **Test After Deploy** - Voert tests uit na elke succesvolle deployment

## API Tests Workflow

De API Tests workflow wordt uitgevoerd bij elke push naar de `main` branch en bij elke pull request naar `main`. Deze workflow zorgt ervoor dat alle API endpoints correct werken voordat code wordt samengevoegd of gedeployed.

### Wat wordt er getest?

- Alle CRM API endpoints (GET, POST, PUT, DELETE)
- Validatie van invoer
- Authenticatie en autorisatie
- Lokalisatie-ondersteuning

### Configuratie

De workflow is geconfigureerd in `.github/workflows/api-tests.yml` en gebruikt de volgende stappen:

1. Checkout van de code
2. Setup van PHP 8.2 met benodigde extensies
3. Installatie van Composer dependencies
4. Configuratie van de testomgeving
5. Uitvoeren van migraties op een test database
6. Uitvoeren van de API tests
7. Sturen van notificaties bij succes of falen

## Test After Deploy Workflow

De Test After Deploy workflow wordt uitgevoerd na elke succesvolle deployment. Deze workflow zorgt ervoor dat de API correct werkt in de productieomgeving na een deployment.

### Wat wordt er getest?

- Beschikbaarheid van kritieke API endpoints
- Basisfunctionaliteit van de CRM API

### Configuratie

De workflow is geconfigureerd in `.github/workflows/test-after-deploy.yml` en wordt getriggerd door een succesvolle deployment status.

## Slack Notificaties

Beide workflows sturen notificaties naar Slack bij succes of falen. Om dit te configureren:

1. Maak een Slack webhook aan in je Slack workspace
2. Voeg het webhook URL toe als een secret in je GitHub repository met de naam `SLACK_WEBHOOK`

## Handmatig Uitvoeren van Tests

Je kunt de API Tests workflow handmatig uitvoeren via de GitHub Actions interface:

1. Ga naar de "Actions" tab in je GitHub repository
2. Selecteer "API Tests" in de lijst met workflows
3. Klik op "Run workflow"
4. Selecteer de branch waarop je de tests wilt uitvoeren
5. Klik op "Run workflow"

## Toevoegen van Nieuwe Tests

Om nieuwe tests toe te voegen:

1. Maak een nieuwe testklasse aan in de `tests/Feature` directory
2. Voeg testmethoden toe die beginnen met `test_` of die geannoteerd zijn met `@test`
3. Voer de tests lokaal uit met `php artisan test`
4. Commit en push de wijzigingen

## Troubleshooting

Als de tests falen in de CI/CD pipeline, maar lokaal slagen:

1. Controleer de GitHub Actions logs voor specifieke foutmeldingen
2. Zorg ervoor dat alle omgevingsvariabelen correct zijn geconfigureerd
3. Controleer of er verschillen zijn tussen je lokale omgeving en de CI/CD omgeving

## Best Practices

1. Schrijf tests voor alle nieuwe API endpoints
2. Zorg ervoor dat tests onafhankelijk van elkaar kunnen worden uitgevoerd
3. Gebruik factories en seeders om testdata te genereren
4. Gebruik asserties om de verwachte resultaten te valideren
5. Houd tests snel en efficiënt

## Contact

Voor vragen over de CI/CD pipeline, neem contact op met het ontwikkelingsteam.
