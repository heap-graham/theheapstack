# WIMS Presentation — Flat File Reference

## Slide fields

| Label | Purpose |
|---|---|
| `heading` | Stand-alone heading |
| `eyebrow` | Small text above the main title |
| `title` | Main slide title |
| `subtitle` | Secondary heading |
| `description` | Descriptive text |
| `text` | General text |
| `author` | Author name |
| `image` | Image path |
| `items` | Bullet-list items, separated by `|` |
| `scope` | Scope statement |
| `note` | Explanatory note |
| `closing` | Closing statement |
| `row` | Table row, with values separated by `|` |
| `type` | Tells PHP which slide structure to render |

## Current `type` values

- `title` — title slide
- `flow` — What? → So What? → What Next?
- `list` — bullet-list slide
- `table` — table slide
- `feedback` — feedback-system diagram

## Slide marker

`[slide]` marks the start of a new slide.

## Basic structure

```text
[slide]
heading=June Fasting Report 2026
image=images/slide-01-mdl.png
```

Each slide can contain only the fields it needs.

The flat file supplies the presentation content.

PHP reads the flat file and generates the HTML structure.

CSS controls the appearance.
