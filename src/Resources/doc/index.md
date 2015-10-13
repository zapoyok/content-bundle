ZapoyokContent
==================

Gestion simpliste de contenu type CMS


Installation
------------

Ajout du bundle dans le fichier `composer.json` :

     "repositories": [         
        {
            "type": "vcs",
            "url": "http://svn.zapoyok.lu/nv-symfony/2.X/zapoyok-content"
        }
        
    ],
    
    {
        "require": {
            "zapoyok/content-bundle": "dev-master"
        }
    }
    
Enregistrer le bundle dans `app/AppKernel.php`:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Zapoyok\ContentBundle\ZapoyokContentBundle(),
        );
    }
    

Configuration
-------------

Préciser le template servant à l'affichage des pages dans le fichier `app/config/config.yml`

    zapoyok_content:
        templates:
            page : "AcmeMainBundle:Content:page.html.twig"
    


Usage 
----

### Pages

Il existe la possibilité de figer des permalinks afin d'éviter que celui-ci ne soit changé.
Pour cela il faut passer le paramètre "locked" à FALSE en base de données directement.
  