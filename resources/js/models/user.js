export default class User {
    constructor(name, email, password) {
      this.name = name;
      this.email = email;
      this.password = password;
    }

    edit(name, email, phone){
      this.name = name;
      this.email = email;
      this.phone = phone;
    }
  }