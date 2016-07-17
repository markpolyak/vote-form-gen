# Form layout description


## Links
- http://www.capture-experts.com/documents/Form_design_guidelines.pdf
    - White space provides a "buffer" around the meaningful data on a form, ensuring that the recognition system can locate data easily even if the document is
scanned at a slight angle or offset. 
        - A margin of at least 1/4" (6.4 mm) around the entire form should be provided. A margin of 1/2" (13 mm) is recommended. 
        - The registration marks should be at least 1/2" away from the edge of the paper. The registration marks should also be at least 3/8" away from any
other black items on the form, colored items that may show up during scanning, or areas where data is to be entered. 
        - 1/4" (6.4 mm) of clear space should be left around each recognition field. This clear space may include items printed in drop-out ink, such as field
constraint lines. 
        - Specified areas for placing endorsement stamps, initials, or signatures should be included but should be placed as far away as possible from any
recognition areas. 
        - If signatures are to be detected as part of the recognition they should be well away form any other data capture areas. Signatures tend to stray
outside the designated area and may overlap other fields, causing errors. 
    - All scanners skew forms as they travel through the feeder mechanism, resulting in image distortion and recognition problems. Registration marks are
special markings on the page that aid the recognition system in de-skewing scanned images. 
        - Use three well-separated marks. This allows all normal combinations of skewing and stretching of the image to be detected, and is essential for forms
that may be faxed.
        - Registration marks should be placed as far apart as possible on the form. The best location is in three corners of the form. By omitting a mark in one
corner, it is possible to auto-detect documents that have been rotated 180 degrees when scanned. 
        - Registration marks should be placed at least 1/2" away from the edge of the paper and at least 3/8" away from any other black items on the form,
colored items that may show up during scanning, or areas where data is to be entered. The further in from the corners the marks are positioned, the
less likely it is that they will be lost when corners of the paper are torn or folded. 
    - Check boxes can be used for multiple choice selections or to indicate that a given item is relevant. The recognition system uses "mark sense recognition"
to determine whether the box has been checked. The system treats any data within the mark sense box as a "yes" response. Therefore, the user can
indicate a choice by filling in the entire box or simply marking with an 'X' or a check mark. A check box can be almost any size, and can be used for
applications such as checking an option or verifying that a signature is present. A well designed form will contain as many yes/no or multiple choice
questions as possible. If space allows, it is worth giving a sample of a check box filled out with an ‘X’, since this is preferable to a tick, which can easily
stray into neighboring boxes. 
        - ~~Check boxes should be printed in drop-out ink.~~ (not relevant to our system as using droup-out ink makes printing expensive)
        - The white space within the check box must be large enough to provide clear and accurate marks. 
        - At least 1/4" (6.4 mm) should be left between check boxes to prevent overlapping of marks destined for one box getting into another. 
        - Clear instructions and examples should be provided to show the user how to fill in the boxes correctly and distinctly. It is recommended to print an X
inside the check boxes as a guide for the user so that he or she knows not to circle the box. This X must be printed in drop-out ink. 
    - If a form has multiple pages, or is double-sided, it is necessary to include page indicators on each page. This will, in most cases, be a page number.
Recognition can perform pre-recognition on the page number to determine which page is being processed and, therefore, what data to expect. 
        - Page numbers should be placed in exactly the same location on every page of the form. 
        - A comfortable margin of white space should be left around the number, about 1/8 inch or 4 mm. The word "page" should not be in this margin. 
    - An alternate page indication method uses rectangles, filled in according to the binary number system, used to signal the recognition system which page is
being read. 
        - The indicator should be placed in exactly the same location on every page of the form.
        - A comfortable margin of white space should be left around it, about 1/8 inch or 4 mm. 
