<?php

    global $micrograph_features;
    $micrograph_features=array();
    $micrograph_features['Cu_structure']=array('Twins', 'Slip lines', 'Dendritic structure', 'Coring', 'Alpha-delta eutectoid');
    $micrograph_features['Fe_structure']=array('Ferrite', 'Pearlite', 'Cementite', 'Martensite', 'Bainite', 'Troostite', 'Neumann bands', 'Weld', 'Widmanstatten', 'Piling');
    $micrograph_features['Porosity']=array('Some porosity', 'High', 'Medium', 'Low');
    $micrograph_features['Corrosion']=array('Intergranular', 'Transgranular', 'Interdendritic', 'Slip plane corrosion', 'Pitting', 'Cracks', 'Redeposited copper');
    $micrograph_features['Inclusions']=array('Copper sulphide', 'Oxides', 'Pb-rich', 'Fe-rich', 'Slag', 'Elongated');
    $micrograph_features['C_content']=array('Homogeneous', 'Heterogeneous', 'Percentage');
    
    //Defines the title to display for each field in the table (used in dispay_details.php, display_table.php, modify.php
    global $field_title;
    $field_title=array();
    //Samples
    $field_title['Sample_type']="Type";
    $field_title['Sample_nb']="Sample code";
    $field_title['Sample_material']="Material";
    $field_title['Sample_condition']="Condition";
    $field_title['Date_sampled']="Date sampled";
    $field_title['Object_part']="Object part";
    $field_title['Section']="Section";
    $field_title['Collection']="Collection";
    $field_title['Tylecote_notebook']="Notebook number<br>(Tylecote collection only)";
    $field_title['Drawer']="Drawer";
    $field_title['Date_repolished']="Date repolished";
    $field_title['Location_new_drawer']="New drawer";
    $field_title['Location_new_code']="New code";
    $field_title['Comment']="Comment";
    $field_title['Location']="Location";               // For the merged location fields in tables_results
    //Objects
    $field_title['Type']="Type";
    $field_title['Description']="Description";
    $field_title['Material']="Material";
    $field_title['Site']="Site";
    $field_title['County']="County/Region";
    $field_title['Country']="Country";
    $field_title['Date_strati']="Date stratigraphy";
    $field_title['Date_typo']="Date typology";
    $field_title['Site_period']="Site period";
    $field_title['Site_layer']="Site layer";
    $field_title['Museum']="Museum";
    $field_title['Museum_nb']="Museum number";
    $field_title['Field_nb']="Field number";
    $field_title['Catalogue_nb']="Catalogue number";
    $field_title['Weight']="Weight (g)";
    $field_title['Length']="Length (mm)";
    $field_title['Width']="Width (mm)";
    $field_title['Thickness']="Thickness (mm)";
    $field_title['Base_diameter']="Base diameter (mm)";
    $field_title['Max_diameter']="Maximum diameter (mm)";
    $field_title['Identification']="Identification no.";    // For the merged code fields in tables_results
    $field_title['Image']="Image";                          // For the merged image fields in tables_results
    //Metallography
    $field_title['Technology']="Technology";
    $field_title['HV']="<a href='/Tylecote_collection/glossary.php'>Hardness HV</a>";
    $field_title['HB']="<a href='/Tylecote_collection/glossary.php'>Hardness HB</a>";
    $field_title['Report']="Report";
    $field_title['Date_metallo']="Date of metallography";
    $field_title['Analyst']="Analyst";
    //Chemistry
    $field_title['Technique']="Technique";
    $field_title['Sampling_method']="Sampling method";
    $field_title['Nb_runs']="Number of runs";
    $field_title['Date_analysed']="Date analysed";
    $field_title['Lab']="Laboratory";
    $field_title['Object_condition']="Object condition";
    //Publication
    $field_title['Author']="Author";
    $field_title['Date']="Date";
    $field_title['Title']="Title";
    $field_title['Journal']="Journal";
    $field_title['Volume']="Volume";
    $field_title['Issue']="Issue";
    $field_title['Pages']="Pages";
    $field_title['Book_title']="Book title";
    $field_title['Editor']="Editor";
    $field_title['City']="City";
    $field_title['Publisher']="Publisher";
    $field_title['Oxf_location']="Bodleian libraries code";
    //Micrographs
    $field_title['Magnification']="Magnification";
    $field_title['Fig_nb']="Figure number";
    $field_title['Cu_structure']="Copper structures";
    $field_title['Fe_structure']="Iron structures";
    $field_title['Porosity']="Porosity";
    $field_title['Corrosion']="Corrosion";
    $field_title['Inclusions']="Inclusions";
    $field_title['C_content']="Carbon content";
    $field_title['Micrograph']="Micrograph";
    $field_title['Micrograph_features']="Micrograph features";  // For the merged features fields in tables_results
    //Thesaurus
    $field_title['Term']="Term";
    
    //Definition of the three chemistry blocks
    $array_chemistry=array();
    $array_chemistry[1]=array("Cu", "Sn", "Pb", "Zn", "Arsenic", "Sb", "Ag", "Ni", "Co", "Bi", "Fe", "Au");
    $array_chemistry[2]=array("C", "Si", "Mn", "P", "S", "Cr", "Ca", "O", "Cd", "Al", "Mg", "K", "Ti", "Se", "Cl");
    $array_chemistry[3]=array("SiO2", "FeO", "MnO", "BaO", "P2O5", "CaO", "Al2O3", "K2O", "MgO", "TiO2", "SO3", "Na2O", "V2O5");
    foreach($array_chemistry as $array)
    {
        foreach($array as $element)
        {
            if($element!="Arsenic")
            {
                $field_title[$element]="% ".$element;
            }   
        }
    }
    $field_title['Arsenic']="% As";
    
    //Array for the definition of the correspondance between the fields proposed in the drop-down menu in tables_choices
    // and the actual fields to be searched in tables_results.
    $fields_correspondance=array();
    $fields_correspondance['All']=array('object.Type', 'object.Material', 'object.Site', 'object.County', 'object.Country', 
        'object.Date_typo', 'object.Date_strati', 'object.Site_period', 'object.Museum', 'sample.sample_Material', 
        'publication.Author', 'publication.Date', 'publication.Title', 'publication.Journal', 'publication.Book_title');
    $fields_correspondance['Type']=array('object.Type');
    $fields_correspondance['Site']=array('object.Site', 'object.County', 'object.Country');
    $fields_correspondance['Date']=array('object.Date_typo', 'object.Date_strati', 'object.Site_period');
    $fields_correspondance['Material']=array('object.Material', 'sample.Sample_material');
    $fields_correspondance['Author']=array('publication.Author');
?>