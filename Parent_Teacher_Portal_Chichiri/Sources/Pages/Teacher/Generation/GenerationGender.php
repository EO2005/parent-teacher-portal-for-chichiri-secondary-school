<?php
    require("../../../../Libraries/Php/FPDF/fpdf.php");
// Define a function to create a PDF with conditional content based on gender and an image
function createPdfWithGenderAndImage($gender) {
    // Create a PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font and size
    $pdf->SetFont('Arial', '', 12);

    // Add content based on gender
    if (strtolower($gender) == 'male') {
        $pdf->Cell(200, 10, "This is a PDF for a male person.", 0, 1, 'C');
        // Add a male-specific image
        $pdf->Image('man.png', 10, 50, 50);
    } elseif (strtolower($gender) == 'female') {
        $pdf->Cell(200, 10, "This is a PDF for a female person.", 0, 1, 'C');
        // Add a female-specific image
        $pdf->Image('girl.png', 10, 50, 50);
    } else {
        $pdf->Cell(200, 10, "Gender not specified.", 0, 1, 'C');
    }

    // Output the PDF to the browser or save it to a file
    $pdf->Output('gender_pdf_with_image.pdf', 'F'); // 'F' saves the PDF to a file

    echo 'PDF generated successfully.';
}

// Example usage:
$gender = 'female';  // You can change this to 'female' or any other value
createPdfWithGenderAndImage($gender);
?>