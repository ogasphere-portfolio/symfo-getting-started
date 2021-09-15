# Nos routes

## Liste des oiseaux

* url : /
* controller : Bird
* méthod : list

## Détail d'un oisal

* url : /bird/{birdName}
* controller : Bird
* method : show

## Téléchargement du calendrier

* url : /calendar
* controller : Bird
* method : calendar

## Api

* url : /api/birds
* controller : Api
* method : all

### Formaat tableau

| URL | Méthode HTTP | Controller | Méthode | Commentaire |
|--|--|--|--|--|
| `/` | `GET` | `BirdController` | `list` | `Liste des oiseaux` 
| `/bird/{id}` | `GET` | `BirdController` | `show` | `Détail d'un oiseau` |
| `/calendar` | `GET` | `BirdController` | `calendar` | `Téléchargement du calendrier` |
