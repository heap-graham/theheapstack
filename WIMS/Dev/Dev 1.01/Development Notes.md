# CSS Standard

Use this ordering inside every CSS block:

1. Layout
2. Size
3. Spacing
4. Border
5. Background
6. Text
7. Effects

Example:

.selector {

    /* Layout */
    display:
    position:
    top:
    right:
    bottom:
    left:

    /* Size */
    width:
    max-width:
    height:

    /* Spacing */
    margin:
    padding:

    /* Border */
    border:
    border-radius:

    /* Background */
    background:
    background-color:

    /* Text */
    color:
    font-family:
    font-size:
    font-weight:
    line-height:
    text-align:

    /* Effects */
    opacity:
    box-shadow:
}

Example body:

body {
    margin: 0;

    background-color: rgb(255,255,255);

    color: rgb(0,32,96);
    font-family: Arial, sans-serif;
    line-height: 2;
}

Example container:

.container {
    max-width: 850px;

    margin: 0 auto;
    padding: 40px 20px;
}
