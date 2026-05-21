# Variables & Data Types in Java

Java is a strongly-typed language, meaning every variable must declare a type during instantiation.

## Primitive Data Types
Java defines 8 primitive types:

| Type | Size (Bytes) | Range | Common Usage |
| :--- | :--- | :--- | :--- |
| `byte` | 1 | -128 to 127 | Low-level streaming |
| `short` | 2 | -32,768 to 32,767 | Saving memory in arrays |
| `int` | 4 | $-2 \times 10^9$ to $2 \times 10^9$ | Standard integers |
| `long` | 8 | $-9 \times 10^{18}$ to $9 \times 10^{18}$ | Large values (append `L` to value) |
| `float` | 4 | 7 decimal digits of precision | Single floats (append `f` to value) |
| `double` | 8 | 15 decimal digits of precision | Default decimal choice |
| `char` | 2 | Single UTF-16 Unicode character | Character matching |
| `boolean` | - | `true` or `false` | Conditional flags |

## Declaring Variables
```java
public class Main {
    public static void main(String[] args) {
        int points = 100;
        long largePoints = 12345678900L;
        double price = 19.99;
        char status = 'S';
        boolean passed = true;

        System.out.println("Points: " + points);
    }
}
```

> [!WARNING]
> Primitives inside class methods are NOT initialized automatically and cause compilation errors if read before being set. Instance variables receive default values (e.g., `0` for numbers, `false` for booleans, `null` for objects).
