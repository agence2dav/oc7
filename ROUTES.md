GET
/api/doc.json

GET
/api/clients/list

    [
        {
            "id": 9,
            "corporation": "d",
            "email": "d@d.d",
            "links": {
            "_links": {
                "self": "/api/clients",
                "clientDetails": "/api/clients/9"
            },
            "title": "H.A.T.E.O.A.S & Resource Linking"
            }
        },
        {
            "id": 10,
            "corporation": "margaux.bruneau",
            "email": "thomas.mallet@tele2.fr",
            "links": {
            "_links": {
                "self": "/api/clients",
                "clientDetails": "/api/clients/10"
            },
            "title": "H.A.T.E.O.A.S & Resource Linking"
            }
        },
    ]

GET
/api/clients

    {
    "id": 9,
    "corporation": "d",
    "email": "d@d.d",
    "links": {
        "_links": {
            "self": "/api/clients",
            "clientDetails": "/api/clients/9"
            },
            "title": "H.A.T.E.O.A.S & Resource Linking"
        }
    }

GET
/api/clients/{id}/users

    {
    "id": 9,
    "corporation": "d",
    "email": "d@d.d",
    "clientUsers": {
            "_links": [
                {
                    "userid": "2",
                    "username": "gregoire.faivre",
                    "href": "/api/clients/9/users/2"
                },
                {
                    "userid": "7",
                    "username": "laurence36",
                    "href": "/api/clients/9/users/7"
                },
            ]
        }
    }

GET
/api/clients/{id}/users/{userId}

    {
    "id": 2,
    "userName": "gregoire.faivre",
    "email": "jacob.nathalie@orange.fr",
    "status": "0",
    "createdAt": "2024-02-14T21:57:02+00:00",
    "userUrl": {
            "_links": {
            "userid": "2",
            "self": "/api/clients/9/users/2"
            }
        }
    }

GET
/api/devices

    [
        {
            "id": 1,
            "name": "Apple iPhone 15",
            "links": {
            "href": "/api/devices/1"
            }
        },
        {
            "id": 2,
            "name": "Apple iPhone 15 Plus",
            "links": {
            "href": "/api/devices/2"
            }
        },
    ]

GET
/api/devices/{id}

    {
    "id": 1,
    "name": "Apple iPhone 15",
    "url": "https://phonesdata.com/fr/smartphones/apple/iphone-15-5463972/",
    "image": "",
    "status": 1,
    "deviceProps": 
        [
            {
            "deviceId": 1,
            "properties": {
                "attribut": "weight",
                "property": "225 gr.",
                "_links": {
                    "self": "/api/devices/property/177",
                    "href": "/api/devices/property/attribut/3"
                    }
                }
            },
        ]
    }

GET
/api/devices/property/{id}

    {
    "id": 3,
    "name": "171 gr.",
    "links": {
            "self": "/api/devices/property/3",
            "href": "/api/devices/property/attribut/3"
        }
    }

GET
/api/devices/property/attribut/{id}

    {
    "id": 3,
    "name": "weight",
    "links": {
            "self": "/api/devices/property/attribut/3"
        }
    }

PUT
/api/users/{id}

DELETE
/api/users/{id}

POST
/api/users

