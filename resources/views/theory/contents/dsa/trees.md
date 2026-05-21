# Trees & Binary Search Trees

A Tree is a hierarchical, non-linear data structure consisting of nodes connected by edges. A tree does not contain any cycles (loops).

```
        ( 1 )      <-- Root Node
       /     \
    ( 2 )   ( 3 )  <-- Child Nodes
```

## Binary Trees vs. Binary Search Trees (BST)
* **Binary Tree**: Each node can have at most **2 children** (referred to as the left child and right child).
* **Binary Search Tree (BST)**: A binary tree with a sorting property:
  * The value of all nodes in the **left subtree** must be strictly *less* than the node's value.
  * The value of all nodes in the **right subtree** must be strictly *greater* than the node's value.

---

## Custom TreeNode Definition (C++)
```cpp
struct TreeNode {
    int val;
    TreeNode* left;
    TreeNode* right;
    
    TreeNode(int x) : val(x), left(nullptr), right(nullptr) {}
};
```

## Tree Traversals
1. **Pre-order** (Root, Left, Right): Used to copy or serialize trees.
2. **In-order** (Left, Root, Right): In a BST, In-order traversal visits nodes in **sorted ascending order**.
3. **Post-order** (Left, Right, Root): Used in bottom-up computations (like deleting a tree or calculating height).
4. **Level-order**: Breadth-First traversal, printing levels sequentially.

---

## Complexity in BST
* **Search / Insert**: $O(H)$ where $H$ is the height of the tree.
  * Balanced tree (e.g. AVL, Red-Black Tree): $H = O(\log N)$
  * Skewed tree (worst case): $H = O(N)$ (behaves like a linked list)
