from SPARQLWrapper import SPARQLWrapper, JSON

f_vid = open("vidFile", "a+")

sparql = SPARQLWrapper("http://dbpedia.org/sparql")
sparql.setQuery("""
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/property/>
PREFIX db: <http://dbpedia.org/>
PREFIX dbr: <http://dbpedia.org/resource/>
PREFIX re: <http://www.w3.org/2000/10/swap/reason#>
prefix foaf: <http://xmlns.com/foaf/0.1/>
prefix : <http://dbpedia.org/ontology/>
prefix res: <http://dbpedia.org/resource/>
SELECT ?x ?vid WHERE {
	?x a :Writer.
    ?x dbo:viafId ?vid.
    ?x dbp:genre ?genre.FILTER regex(?genre, "fiction").} 
""")

sparql.setReturnFormat(JSON)
results = sparql.query().convert()
count = 0
for vidResult in results["results"]["bindings"]:
	count=count+1
	print(vidResult["vid"]["value"])
	f_vid.write(vidResult["vid"]["value"]+"\n")

print(count)
f_vid.close()










