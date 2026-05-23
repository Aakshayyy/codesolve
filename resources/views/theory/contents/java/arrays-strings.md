# Java Arrays & Strings

Arrays and Strings are foundational non-primitive data types in Java. Understanding their internal architecture and manipulation methods is critical for problem-solving.

---

## Java Arrays

An array is a container object that holds a fixed number of values of a single type.

### Declaring & Initializing Arrays
```java
// Method 1: Declare and allocate size
int[] arr = new int[5];

// Method 2: Declare and initialize directly
int[] numbers = {10, 20, 30, 40, 50};
```

### Accessing & Looping through Arrays
```java
public class Main {
    public static void main(String[] args) {
        int[] numbers = {10, 20, 30, 40};

        // Accessing via index (0-indexed)
        System.out.println(numbers[0]); // Outputs: 10

        // Modifying elements
        numbers[1] = 25;

        // Loop using length attribute
        for (int i = 0; i < numbers.length; i++) {
            System.out.print(numbers[i] + " ");
        }
    }
}
```

### Multi-Dimensional Arrays (2D Arrays)
A multi-dimensional array is an array of arrays:
```java
int[][] matrix = {
    {1, 2, 3},
    {4, 5, 6}
};
System.out.println(matrix[0][1]); // Outputs: 2 (row 0, column 1)
```

---

## Java Strings

In Java, a `String` is an object that represents a sequence of characters. Strings are **immutable**, meaning once created, their values cannot be changed.

### String Immutability & The String Pool
When you create a string literal, JVM checks the **String Constant Pool**. If the string already exists, it reuses the reference, saving memory. If you modify a string, a new string object is created in memory:

```java
String s1 = "Hello";
s1 = s1 + " World"; // Creates a new string object "Hello World"
```

### Common String Methods
Here are some of the most useful methods on Java String objects:

| Method | Return Type | Description | Example |
| :--- | :--- | :--- | :--- |
| `length()` | `int` | Returns the number of characters in the string | `"Hi".length() // 2` |
| `charAt(int i)` | `char` | Returns the character at index `i` | `"Java".charAt(0) // 'J'` |
| `substring(int start, int end)` | `String` | Returns a substring from `start` to `end - 1` | `"Hello".substring(1, 4) // "ell"` |
| `equals(Object obj)` | `boolean` | Compares content equality (never use `==` for strings) | `s1.equals(s2)` |
| `indexOf(String s)` | `int` | Returns index of first occurrence of substring `s` | `"test".indexOf("es") // 1` |
| `toCharArray()` | `char[]` | Converts the string to a character array | `char[] arr = s1.toCharArray();` |

---

## StringBuilder & StringBuffer

Because `String` is immutable, performing repetitive string modifications (like concatenation in a loop) is slow and memory-intensive. 
We use **`StringBuilder`** (non-thread-safe, faster) or **`StringBuffer`** (thread-safe, slower) for mutable strings:

```java
public class Main {
    public static void main(String[] args) {
        StringBuilder sb = new StringBuilder("Hello");
        
        for (int i = 0; i < 5; i++) {
            sb.append("!");
        }
        
        String result = sb.toString();
        System.out.println(result); // Outputs: Hello!!!!!
    }
}
```
