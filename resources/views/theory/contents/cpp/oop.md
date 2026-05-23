# C++ OOP (Object-Oriented Programming)

Object-Oriented Programming (OOP) is a programming paradigm that organizes software design around data, or objects, rather than functions and logic. An object is a data field that has unique attributes and behavior.

---

## Classes & Objects

- **Class**: A template/blueprint for creating objects.
- **Object**: An instance of a class.

```cpp
#include <iostream>
using namespace std;

// Class declaration
class Car {
  public:
    string brand;
    string model;
    int year;
};

int main() {
    // Create an object of Car
    Car carObj1;
    carObj1.brand = "BMW";
    carObj1.model = "X5";
    carObj1.year = 1999;

    cout << carObj1.brand << " " << carObj1.model << "\n";
    return 0;
}
```

---

## Access Specifiers

Access specifiers define how the members (attributes and methods) of a class can be accessed:
- **`public`**: Members are accessible from outside the class.
- **`private`**: Members cannot be accessed (or viewed) from outside the class (default).
- **`protected`**: Members cannot be accessed from outside the class, but they can be accessed in inherited classes.

```cpp
class MyClass {
  public:    // Public access specifier
    int x;   // Public attribute
  private:   // Private access specifier
    int y;   // Private attribute
};
```

---

## Constructors

A constructor is a special method that is automatically called when an object of a class is created. It has the same name as the class and does not have a return type:

```cpp
#include <iostream>
using namespace std;

class Car {
  public:
    string brand;
    int year;

    // Constructor with parameters
    Car(string x, int y) {
      brand = x;
      year = y;
    }
};

int main() {
    Car carObj("Ford", 1969);
    cout << carObj.brand << " " << carObj.year << "\n";
    return 0;
}
```

---

## The Four Pillars of OOP

### 1. Encapsulation
Encapsulation is making sure that "sensitive" data is hidden from users. This is achieved by declaring class variables as `private` and providing public **getter** and **setter** methods.

```cpp
class Employee {
  private:
    int salary; // Private attribute
  public:
    void setSalary(int s) { salary = s; }
    int getSalary() { return salary; }
};
```

### 2. Inheritance
Inheritance is the capability of a class to derive properties and characteristics from another class. We use the colon (`:`) symbol to inherit:

```cpp
// Base class (Parent)
class Vehicle {
  public:
    string brand = "Ford";
    void honk() { cout << "Tuut, tuut!\n"; }
};

// Derived class (Child)
class Car: public Vehicle {
  public:
    string model = "Mustang";
};
```

### 3. Polymorphism
Polymorphism means "many forms", and it occurs when we have many classes that are related to each other by inheritance. It allows us to perform a single action in different ways (e.g. function overriding).

```cpp
class Animal {
  public:
    virtual void animalSound() {
      cout << "The animal makes a sound \n";
    }
};

class Pig : public Animal {
  public:
    void animalSound() override {
      cout << "The pig says: wee wee \n";
    }
};
```

### 4. Abstraction
Data abstraction is the property by which only the essential details are displayed to the user. This is achieved using **abstract classes** (classes containing at least one **pure virtual function**):

```cpp
// Abstract class (cannot be instantiated directly)
class Smartphone {
  public:
    virtual void makeCall() = 0; // Pure virtual function
};

class iPhone : public Smartphone {
  public:
    void makeCall() override {
      cout << "Calling via iOS UI...\n";
    }
};
```
