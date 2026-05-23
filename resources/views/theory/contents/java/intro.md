# Java Introduction

Java is a popular, class-based, object-oriented programming language developed by **James Gosling** at Sun Microsystems in 1995. It is owned by Oracle, and more than 3 billion devices run Java.

---

## The Java Philosophy: Write Once, Run Anywhere (WORA)

Java's main advantage is its platform independence. The Java compiler converts source code (`.java` files) into **Bytecode** (`.class` files), which can run on any device that has a **Java Virtual Machine (JVM)** installed.

```
+------------------+     Java Compiler (javac)     +----------------+
|  MyProgram.java  |  =========================>  | MyProgram.class|
+------------------+                              +----------------+
                                                          ||
                                                          || JVM
                                                          \/
                                                 +-------------------+
                                                 | Machine execution |
                                                 +-------------------+
```

---

## Core Java Components (JDK, JRE, JVM)

1. **JVM (Java Virtual Machine)**: The engine that executes the Java bytecode.
2. **JRE (Java Runtime Environment)**: JVM + Libraries required to run Java applications.
3. **JDK (Java Development Kit)**: JRE + Development Tools (compiler, debugger). You need the JDK to write and compile Java code.

---

## Basic Structure of a Java Program

Every line of code that runs in Java must be inside a `class`. In our examples, we name the class `Main`. The file name must match the class name (`Main.java`).

```java
public class Main {
    public static void main(String[] args) {
        System.out.println("Hello World");
    }
}
```

### Code Explanation:
- **`public class Main`**: Declares a class named `Main`. In Java, classes should start with an uppercase first letter.
- **`public static void main(String[] args)`**: The `main()` method is the entry point of any Java program. It must be `public` (accessible to JVM), `static` (run without creating class objects), and return `void`.
- **`System.out.println()`**: A built-in class/method combination used to print text to the standard output.

---

## W3Schools Style: Input and Output Examples

### 1. Printing Output
- `System.out.print()`: Prints on the same line.
- `System.out.println()`: Prints and moves cursor to a new line.

```java
public class Main {
    public static void main(String[] args) {
        System.out.print("Hello ");
        System.out.println("World!"); // Outputs: Hello World!
    }
}
```

### 2. Standard Input (Scanner)
To read user input, we use the `Scanner` class from the `java.util` package:

```java
import java.util.Scanner; // Import Scanner class

public class Main {
    public static void main(String[] args) {
        Scanner myObj = new Scanner(System.in);
        System.out.println("Enter username: ");

        String userName = myObj.nextLine(); // Read user input
        System.out.println("Username is: " + userName);
    }
}
```

### 3. Fast Input (BufferedReader) for Competitive Coding
When solving computational problems with massive inputs, the standard `Scanner` is slow. We use `BufferedReader` and `StringTokenizer` for faster operations:

```java
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.IOException;
import java.util.StringTokenizer;

public class Main {
    public static void main(String[] args) throws IOException {
        BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
        StringTokenizer st = new StringTokenizer(br.readLine());
        
        int a = Integer.parseInt(st.nextToken());
        int b = Integer.parseInt(st.nextToken());
        
        System.out.println("Sum: " + (a + b));
    }
}
```
