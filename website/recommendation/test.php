<html>
    <title>test1</title>
    <body>
        <?php   
        
        //set_include_path(".:/Applications/MAMP/htdocs/recommendation:");
        echo "1";
        require_once "/Applications/MAMP/htdocs/recommendation/phpSesame/phpSesame.php";
        echo "2";
        
        $sesame = array('url' => 'http://localhost:8080/openrdf-sesame', 'repository' => '1');
        
        $store = new phpSesame($sesame['url'], $sesame['repository']);
        echo "3";
        
        $sparql = "prefix	db:	<http://dbpedia.org/ontology/Building>
prefix	dbo: <http://dbpedia.org/ontology/>
prefix dbp: <http://dbpedia.org/property/>
prefix dbr:	<http://dbpedia.org/resource/>
prefix rdf:	<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
prefix schema: <http://schema.org/>
select  ?name
where{?x schema:name ?name.FILTER(?name=\"Cain's Blood\")}";


        $resultFormat = phpSesame::SPARQL_XML; // The expected return type, will return a phpSesame_SparqlRes object (Optional)
        $lang = "sparql"; // Can also choose SeRQL (Optional)
        $infer = true; // Can also choose to explicitly disallow inference. (Optional)

        $result = $store->query($sparql, $resultFormat, $lang, $infer);

        if($result->hasRows()) {
                foreach($result->getRows() as $row) {
                        echo "Subject: " . $row['name'];
                }
        }
        else{
            echo "no results";
        }
        
        ?>
    </body>
</html>