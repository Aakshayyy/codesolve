# OOP Concepts in Java

Java is a pure object-oriented language. Except for primitive types, everything in Java behaves as an object extending from the base `java.lang.Object` class.

## Class Definition
Classes encapsulate fields and method actions:

```java
public class Solution {
    private int score; // Encapsulation

    // Constructor
    public Solution(int score) {
        this.score = score;
    }

    // Getter
    public int getScore() {
        return this.score;
    }

    public static void main(String[] args) {
        Solution s = new Solution(95);
        System.out.println("Score: " + s.getScore());
    }
}
```

## Overriding and Dynamic Dispatch
Inheritance uses the `extends` keyword. Child classes can override parent methods. Annotating with `@Override` is recommended to prevent parameter mismatch bugs.

```java
class Animal {
    void makeSound() {
        System.out.println("Generic Sound");
    }
}

class Dog extends Animal {
    @Override
    void makeSound() {
        System.out.println("Bark");
    }
}
```
