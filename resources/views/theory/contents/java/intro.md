# Introduction to Java (JVM/JDK)

Java is a popular, class-based, object-oriented programming language designed to have as few implementation dependencies as possible. The core philosophy is **"Write Once, Run Anywhere" (WORA)**.

## The Java Execution Engine
To run Java code, three core systems coordinate together:

* **JVM (Java Virtual Machine)**: An abstract machine that executes Java bytecode. JVM handles memory allocation, thread execution, and runtime checks.
* **JRE (Java Runtime Environment)**: A software package containing JVM along with standard Java class libraries to run Java applications.
* **JDK (Java Development Kit)**: A full software development environment containing JRE, compiler (`javac`), and debugging tools needed to compile and build Java apps.

```
+-------------------------------------------------+
|                   JDK                           |
|  +------------------------------+   +--------+  |
|  |             JRE              |   | javac  |  |
|  |  +-------+  +-------------+  |   | jdb    |  |
|  |  |  JVM  |  | Libraries   |  |   | etc.   |  |
|  |  +-------+  +-------------+  |   +--------+  |
|  +------------------------------+               |
+-------------------------------------------------+
```

---

## Basic Syntax Structure
In Java, all executable instructions are contained inside classes. The main method is the entry point:

```java
public class Main {
    public static void main(String[] args) {
        System.out.println("Hello, CodeSolve Java Academy!");
    }
}
```

> [!IMPORTANT]
> The public class name MUST exactly match the file name (e.g., `Main` class inside `Main.java` file), or a compilation error is thrown.
