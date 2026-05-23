# Java OOP Concepts

Object-Oriented Programming (OOP) is a programming style that organizes code around objects (data) rather than actions (functions). In Java, everything is associated with classes and objects.

---

## Classes & Objects

A class is a blueprint for creating objects. An object is an instance of a class.

```java
// Class declaration
class Car {
    String brand;
    int year;

    // Class Method
    public void honk() {
        System.out.println("Tuut, tuut!");
    }
}

public class Main {
    public static void main(String[] args) {
        // Create an object of Car
        Car myCar = new Car();
        myCar.brand = "Ford";
        myCar.year = 1969;
        
        myCar.honk(); // Call method
    }
}
```

---

## Access Modifiers

Access modifiers control the visibility of classes, attributes, methods, and constructors:
- **`public`**: Accessible from any class in any package.
- **`private`**: Accessible only within the declared class.
- **`protected`**: Accessible in the same package and subclasses.
- **Default (no modifier)**: Accessible only within classes in the same package.

---

## Constructors

A constructor is a block of code similar to a method that is called when an instance of an object is created.

```java
class Student {
    String name;

    // Constructor
    public Student(String studentName) {
        name = studentName;
    }
}
```

---

## The Four Pillars of OOP in Java

### 1. Encapsulation
Encapsulation involves hiding internal state variables and requiring all interaction to be performed through public methods (Getters/Setters).

```java
class Person {
    private String name; // Private field

    public String getName() { return name; } // Getter
    public void setName(String newName) { this.name = newName; } // Setter
}
```

### 2. Inheritance
Inheritance allows one class to inherit the attributes and methods of another class. We use the **`extends`** keyword:

```java
class Vehicle {
    protected String brand = "Ford";
}

class Car extends Vehicle {
    private String model = "Mustang";
}
```

### 3. Polymorphism
Polymorphism means "many forms", and it occurs when we have subclasses that inherit from a parent class, overriding its methods:

```java
class Animal {
    public void makeSound() {
        System.out.println("The animal makes a sound");
    }
}

class Pig extends Animal {
    @Override
    public void makeSound() {
        System.out.println("The pig says: wee wee");
    }
}
```

### 4. Abstraction
Abstraction is the process of hiding implementation details and showing only functionality to the user. We use **`abstract` classes** or **`interfaces`**:

```java
// Abstract Class
abstract class Animal {
    public abstract void animalSound(); // Abstract method (no body)
}

// Interface (100% abstract by default)
interface Flyable {
    void fly();
}

class Bird implements Flyable {
    public void fly() {
        System.out.println("Bird is flying.");
    }
}
```
