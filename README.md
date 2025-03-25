# Main goal

Split domain entities and data store entities to work strictly hexagonal/DDD

# What do we want

- [x] use value objects in domain and primitives in data store -> from the beginning!
- [ ] ~~use separate identifier in domain (something unique like username/slug) and data store (id)~~ -> nope, we need matching ID's and it needs to be something that can never change. Username/slug CAN possibly change later, so probably always use separate ID's
- [ ] a DDD way of database transactions -> no ``flush`` in repository (keep in mind that you can have different data stores)
- [ ] asymmetric relations: use objects when making a relation, use identifiers when getting a relation ``->setUserGroup($group)`` and ``->getUserGroupId()`` -> how does this work with retrieving an entity since the whole object is needed in the constructor?
- [ ] use nullable composed value objects
    - [ ] improve this by using separate classes in doctrine entities to make it DRY -> traits?

# How to test

- [ ] create method in test
- [ ] update method in test
- [ ] read method in test
    - [ ] custom query with relations in test
- [ ] delete method in test
- [ ] have a root aggregate with children for all of the above

# Questions

- [ ] Do we need to have separate CRUD methods in repository?
- [ ] Do we need reflection for repo/mapper?

# Reads

- https://mbarkt3sto.hashnode.dev/ddd-entity-vs-value-object-vs-aggregate-root
- https://symfony.com/doc/current/doctrine/associations.html
- https://medium.com/unil-ci-software-engineering/clean-ddd-lessons-modeling-identity-ff8bc17e0ae6
- https://matthiasnoback.nl/2022/04/ddd-entities-and-orm-entities/