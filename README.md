# webb3projekt-del1

Denna del av Projektet är till för att hantera den underliggande REST-webbtjänsten och tillhandahåller den CRUD-funktionalitet som används i administrations samt användar-sidan.

Detta görs genom att skapa en anslutning till en MySqli databas genom en config-fil för att sedan med PHP-filer skapa kod för de olika CRUD-funktionerna som kommer användas av de andra webbprojekt-delarna. 

Den MySqli databas som skapats har tre stycken tabeller och kategorier med information, studier(http://studenter.miun.se/~olfa1902/Webbutveckling_III/Projektuppgift/REST/studies.php), arbetslivserfarenheter(http://studenter.miun.se/~olfa1902/Webbutveckling_III/Projektuppgift/REST/experiences.php) och webbplatser(http://studenter.miun.se/~olfa1902/Webbutveckling_III/Projektuppgift/REST/webpages.php), som de övriga delarna i projektet ansluter sig till och skriver ut, ändrar, lägger till eller tar bort information ifrån.
