# Laravel & VueJs Demo App

This is a simple product/category CRUD application (sorry just CRD for now 😄)

A product has a name, a description, a price and an image.    
A category has a name and can have a parent category.    
A product can have between 0 and 2 categories.

## Features
### CLI
- You can create and delete a category from the command line
- You can create and delete a product from the command line

### Web
- You can create a product
- You can browse products through a product listing with ability to:
    - sort by name, by price
    - filter by a category
    
### Tests
Tests only cover product creation
    
## Improvments that are needed
- Products pagination
- Create product thumbnail
- Frontend validation
- More tests!
