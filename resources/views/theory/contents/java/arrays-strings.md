# Arrays & Strings in Java

Arrays and Strings are core containers. In Java, both are represented as objects.

## 1. Java Arrays
An array is a fixed-size, contiguous block of elements of the same type.
* Declared using `[]`.
* Length is accessed using the `.length` property.

```java
int[] arr = new int[5]; // Initialize with size 5 (default elements are 0)
arr[0] = 10;

int[] inlineArr = {1, 2, 3, 4, 5};
System.out.println("Array Length: " + inlineArr.length);
```

## 2. Java Strings
A String is an immutable object representing text.
* Strings are stored inside a special memory segment called the **String Constant Pool** to conserve memory.
* Because they are immutable, modifications generate new String objects.
* String length is accessed using the `.length()` method.
* Character retrieval is done via `.charAt(index)`.

```java
String name = "CodeSolve";
char firstChar = name.charAt(0); // 'C'
int len = name.length(); // 9
```

> [!TIP]
> Avoid repeatedly concatenating Strings in loops (e.g., `s += "a"`). This creates $O(N)$ objects and degrades performance to $O(N^2)$. Use `StringBuilder` instead, which updates a mutable buffer in $O(1)$ amortized time:
> ```java
> StringBuilder sb = new StringBuilder();
> for (int i = 0; i < 1000; i++) {
>     sb.append(i);
> }
> String result = sb.toString();
> ```
