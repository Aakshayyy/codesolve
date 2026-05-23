# DSA Trees & BSTs

A Tree is a non-linear, hierarchical data structure that consists of nodes connected by edges. Unlike arrays and linked lists which are linear, trees represent hierarchical relationships (like a family tree or file directories).

```
          [ 1 ]          <- Root Node
         /     \
      [ 2 ]   [ 3 ]      <- Parent / Child Nodes
      /   \
   [ 4 ] [ 5 ]           <- Leaf Nodes (no children)
```

---

## 1. Binary Tree

A **Binary Tree** is a tree structure in which each parent node has at most two children, referred to as the left child and the right child.

### Binary Tree traversals
There are four common ways to traverse (visit all nodes of) a binary tree:

1. **Pre-order (Root -> Left -> Right)**: Visit root, traverse left subtree, traverse right subtree.
2. **In-order (Left -> Root -> Right)**: Traverse left, visit root, traverse right. (For a BST, this visits elements in **sorted ascending order**).
3. **Post-order (Left -> Right -> Root)**: Traverse left, traverse right, visit root. (Useful for deleting a tree from leaf to root).
4. **Level-order (Breadth-First Search)**: Visit nodes level-by-level from top to bottom, left to right.

---

## 2. Binary Search Tree (BST)

A **Binary Search Tree** is a binary tree with the following ordering properties:
- The left subtree of a node contains only nodes with values **less than** the node's value.
- The right subtree of a node contains only nodes with values **greater than** the node's value.
- The left and right subtrees must also be binary search trees.

```
          [ 8 ]
         /     \
      [ 3 ]   [ 10 ]
      /   \       \
   [ 1 ] [ 6 ]   [ 14 ]
```

---

## Core BST Operations & Time Complexities

The efficiency of BST operations depends on the height ($H$) of the tree.

| Operation | Average Case | Worst Case (Skewed Tree) | Description |
| :--- | :--- | :--- | :--- |
| **Search** | $O(\log N)$ | $O(N)$ | Eliminate half the tree at each step. |
| **Insertion** | $O(\log N)$ | $O(N)$ | Traverse to leaf position and insert. |
| **Deletion** | $O(\log N)$ | $O(N)$ | Remove node and reorganise references. |

- **Balanced Trees**: In a balanced BST (like AVL Tree or Red-Black Tree), $H = \log N$, ensuring $O(\log N)$ runtimes for all operations.
- **Skewed Trees**: If elements are inserted in sorted order (e.g. 1, 2, 3, 4), the tree becomes a single line, and height $H = N$, degrading runtimes to $O(N)$.

---

## BST Java Implementation & In-Order Traversal

```java
class TreeNode {
    int val;
    TreeNode left, right;

    public TreeNode(int val) {
        this.val = val;
        this.left = this.right = null;
    }
}

public class Main {
    // Insert into BST
    public static TreeNode insert(TreeNode root, int val) {
        if (root == null) {
            return new TreeNode(val);
        }
        if (val < root.val) {
            root.left = insert(root.left, val);
        } else {
            root.right = insert(root.right, val);
        }
        return root;
    }

    // In-order traversal (prints sorted values)
    public static void inorder(TreeNode root) {
        if (root != null) {
            inorder(root->left);
            System.out.print(root->val + " ");
            inorder(root->right);
        }
    }

    public static void main(String[] args) {
        TreeNode root = null;
        root = insert(root, 50);
        insert(root, 30);
        insert(root, 70);
        insert(root, 20);

        inorder(root); // Outputs: 20 30 50 70
    }
}
```
