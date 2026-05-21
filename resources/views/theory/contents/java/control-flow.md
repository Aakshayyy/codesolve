# Control Flow in Java

Java supports standard conditional branching and loops to guide execution flow.

## 1. Decision Making (`if`, `else if`, `else`)
Evaluates boolean expressions to branch execution.

```java
public class Main {
    public static void main(String[] args) {
        int x = 20;

        if (x > 15) {
            System.out.println("Greater than 15");
        } else {
            System.out.println("Less than or equal to 15");
        }
    }
}
```

## 2. Iterations (Loops)
* **`for` loop**: Standard loops when limits are known.
* **`while` loop**: Continues while condition remains true.
* **Enhanced `for-each` loop**: Used to traverse arrays or collections sequentially.

```java
public class Main {
    public static void main(String[] args) {
        // Standard For loop
        for (int i = 0; i < 3; i++) {
            System.out.print(i + " ");
        }
        System.out.println();

        // Enhanced For loop (For-each)
        int[] nums = {10, 20, 30};
        for (int num : nums) {
            System.out.print(num + " ");
        }
    }
}
```
