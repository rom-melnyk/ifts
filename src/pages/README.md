# `list.json` file
This is the array of objects. Each should contain following fields:

- `title`: the overlay title,
- `description`: short description on the main page,
- `icon`: the icon class (from the [http://fortawesome.github.io/Font-Awesome/icons/]), for instance, `fa-map-marker`,
- `script`,
- `action`,
- `body-ref`: the name of appropriate `*.html` file (without extension!).

The order of objects matters!

# `.html` file
The regular html file containing the HTML fragment to be placed in the overlay

---

# Including files
Don't forget to import `*.html` files
