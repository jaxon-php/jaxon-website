#### Blogging

The `pages/06.blog` directory contains the blog pages.
The link of the blog pages are in the form `/blog/2020/06/blog-entry-title`,
and each entry is supposed to have an image for illustration.

Therefore, the blog pages will be located in a 3 level directory hierarchy.
The first level directory name is the year.
The second level directory name is the month.
The third level directory name is the slug of the blog entry title.

The first and second level directories must contain a `item.md` file with the following content.

```markdown
---
published: false
---
```
It will prevent these pages from being listed in the main blog page.

The third level directory contains the blog entry content.
Each entry header must define a date in the following format `17:34 05/01/2020`.
The date is mandatory because the blog entries are ordered by date in the blog main page.
A list of tags can also be define in the `taxonomy.tag` header.
This is an example of a blog entry header.
```markdown
---
title: 'Why Jaxon'
date: '17:34 05/01/2020'
taxonomy:
    category:
        - blog
    tag:
        - photography
        - architecture
        - ajax
---
```

The image which illustrates each blog entry is stored in the same directory.
It will be resized later, and copied into the `images` directory by the CMS.
The images must be in the 9:6 format.

Additional meta data can be added foreach image.
They are defined in a file with the same name as the image, suffixed with `meta.yaml`.
They are used for example to define images source and author data for credits.
