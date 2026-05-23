# Java Control Flow

Java control statements control the execution order of your program based on conditional checks or repetition of blocks using loops.

---

## Conditionals (If...Else)

Java conditional statements are used to perform different actions based on different conditions.

```java
public class Main {
    public static void main(String[] args) {
        int time = 22;
        if (time < 10) {
            System.out.println("Good morning.");
        } else if (time < 20) {
            System.out.println("Good day.");
        } else {
            System.out.println("Good evening.");
        }
        // Outputs: "Good evening."
    }
}
```

### Ternary Operator (Short Hand If...Else)
```java
String result = (time < 18) ? "Good day." : "Good evening.";
```

### Switch Statement
The `switch` statement selects one of many code blocks to be executed.

```java
public class Main {
    public static void main(String[] args) {
        int day = 4;
        switch (day) {
            case 6:
                System.out.println("Today is Saturday");
                break;
            case 7:
                System.out.println("Today is Sunday");
                break;
            default:
                System.out.println("Looking forward to the Weekend");
        }
    }
}
```

---

## Repetitive Code: Java Loops

Loops run a block of code as long as a specified condition is true.

### 1. While Loop
The `while` loop checks the condition before executing the loop body:

```java
int i = 0;
while (i < 5) {
    System.out.print(i + " ");
    i++;
}
// Outputs: 0 1 2 3 4
```

### 2. Do/While Loop
The `do/while` loop checks the condition after executing the body once:

```java
int i = 0;
do {
    System.out.print(i + " ");
    i++;
} while (i < 5);
// Outputs: 0 1 2 3 4
```

### 3. For Loop
Used when you know exactly how many times the loop should run:

```java
for (int i = 0; i < 5; i++) {
    System.out.print(i + " ");
}
// Outputs: 0 1 2 3 4
```

### 4. For-Each Loop (Enhanced For Loop)
Used exclusively to loop through elements in arrays and Collections:

```java
String[] cars = {"Volvo", "BMW", "Ford", "Mazda"};
for (String car : cars) {
    System.out.println(car);
}
```

---

## Break & Continue

- **`break`**: Terminates the loop immediately.
- **`continue`**: Skips the current iteration and jumps to the next iteration evaluation.

```java
public class Main {
    public static void main(String[] args) {
        for (int i = 0; i < 10; i++) {
            if (i == 4) {
                continue; // Skip printing 4
            }
            if (i == 8) {
                break; // Terminate loop at 8
            }
            System.out.print(i + " ");
        }
        // Outputs: 0 1 2 3 5 6 7
    }
}
```
