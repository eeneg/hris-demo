export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdministrator(){
        return this.user.role == 'Administrator';
    }

    isOfficeUser(){
        return this.user.role == 'Office User';
    }

    isAuthor(){
        return this.user.role == 'Author';
    }

    isAdministratorORAuthor(){
        return this.user.role == 'Administrator' || this.user.role == 'Author';
    }
}