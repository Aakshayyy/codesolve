# Java Variables & Data Types

Variables are containers for storing data values. Java is a **strongly typed language**, which means that all variables must be declared with a data type before they can be used.

---

## Declaring Java Variables

To create a variable, specify the type and assign it a value:

```java
type variableName = value;
```

### Example:
```java
public class Main {
    public static void main(String[] args) {
        String name = "John";
        int myNum = 15;
        float myFloatNum = 5.99f;
        char myLetter = 'D';
        boolean myBool = true;

        System.out.println(name);
        System.out.println(myNum);
    }
}
```

---

## Data Types in Java

Data types in Java are divided into two groups:

### 1. Primitive Data Types
Primitive types specify the size and type of variable values. They do not have built-in methods.

| Data Type | Size (Bytes) | Description | Example |
| :--- | :--- | :--- | :--- |
| `byte` | 1 byte | Stores whole numbers from -128 to 127 | `byte b = 100;` |
| `short` | 2 bytes | Stores whole numbers from -32,768 to 32,767 | `short s = 5000;` |
| `int` | 4 bytes | Stores whole numbers from -2,147,483,648 to 2,147,483,647 | `int i = 50000;` |
| `long` | 8 bytes | Stores whole numbers (suffix 'L' is recommended) | `long l = 15000000000L;` |
| `float` | 4 bytes | Stores fractional numbers (suffix 'f' is required) | `float f = 5.75f;` |
| `double` | 8 bytes | Stores fractional numbers up to 15 decimal digits | `double d = 19.99d;` |
| `boolean` | 1 bit | Stores true or false values | `boolean isJavaFun = true;` |
| `char` | 2 bytes | Stores a single character/letter or ASCII value | `char grade = 'A';` |

### 2. Non-Primitive Data Types
Non-primitive types refer to objects and are called **reference types**. They can contain methods, can be `null`, and are created by the programmer (except `String`, which is built-in):
- `String`
- `Arrays`
- `Classes`
- `Interfaces`

---

## Constants (final)

If you want to prevent a variable from being modified, use the `final` keyword (which behaves like `const` in other languages):

```java
public class Main {
    public static void main(String[] args) {
        final int myNum = 15;
        // myNum = 20; // Error: cannot assign a value to final variable myNum
        System.out.println(myNum);
    }
}
```

---

## Java Type Casting

Type casting is when you assign a value of one primitive data type to another type.

### Widening Casting (Automatically)
Converting a smaller type to a larger type size:
`byte` -> `short` -> `char` -> `int` -> `long` -> `float` -> `double`

```java
int myInt = 9;
double myDouble = myInt; // Automatic casting: int to double
```

### Narrowing Casting (Manually)
Converting a larger type to a smaller type size:
`double` -> `float` -> `long` -> `int` -> `char` -> `short` -> `byte`

```java
double myDouble = 9.78d;
int myInt = (int) myDouble; // Manual casting: double to int
```
> [!NOTE]
> Narrowing casting truncates decimal values (e.g. `9.78` becomes `9`), leading to a loss of precision.
