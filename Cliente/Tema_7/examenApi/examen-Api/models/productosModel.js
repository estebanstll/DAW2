class Product {
  constructor(id, name, description, price, user) {
    this.id = id;
    this.name = name;
    this.description = description;
    this.price = price;
    this.user = user;
    this.dateCreation = new Date().toISOString();
  }
}
module.exports = Product;
