#INPUT vidFile 
#to read collected vid of writers
#OUTPUT authorResult1
#to write author information as a dictionary 

from SPARQLWrapper import SPARQLWrapper, JSON
import json

f_vid = open("vidFile", "r")

for vid in f_vid:
	print(vid)
	vid = vid.strip()
	queryString = 'prefix db: <http://dbpedia.org/ontology/Building>\
	 prefix	dbo: <http://dbpedia.org/ontology/>\
	 prefix dbp: <http://dbpedia.org/property/>\
	 prefix dbr:	<http://dbpedia.org/resource/>\
	 prefix rdf:	<http://www.w3.org/1999/02/22-rdf-syntax-ns#>\
	 select  ?vid ?name ?birthDate ?nationality ?genre  ?description ?influenced ?influencedBy\
	 where{\
	     ?x rdf:type dbo:Writer.\
         ?x dbo:viafId ?vid.FILTER(?vid="%s"^^<http://www.w3.org/2001/XMLSchema#string>)\
         ?x dbp:name ?name.\
         OPTIONAL{?x dbp:genre ?genre.}\
         OPTIONAL{?x dbo:birthDate ?birthDate.}\
         OPTIONAL{?x dbp:nationality ?nationality.}\
         OPTIONAL{?x dc:description ?description.}\
         OPTIONAL{?x dbo:influenced ?influenced.}\
         OPTIONAL{?x dbo:influencedBy ?influencedBy.}}' % vid
	print(queryString+"\n")
	
	_sparql = SPARQLWrapper("http://dbpedia.org/sparql")
	_sparql.setQuery(queryString)
	_sparql.setReturnFormat(JSON)
	rows = _sparql.query().convert()


	dict1 = {}
	name = []
	birthDate = []
	nationality = []
	genre = []
	description = []
	influenced = []
	influencedBy = []

	print("len:  "+ str(len(rows["results"]["bindings"])))

	for row in rows["results"]["bindings"]:

		try:
			if row["name"]["value"] not in name:
				name.append(row["name"]["value"])
		except KeyError:
			pass

		try:
			if row["birthDate"]["value"] not in birthDate:
				birthDate.append(row["birthDate"]["value"])
		except KeyError:
			pass

		try:
			if row["nationality"]["value"] not in nationality:
				nationality.append(row["nationality"]["value"])
		except KeyError:
			pass

		try:
			if row["genre"]["value"] not in genre:
				genre.append(row["genre"]["value"])
		except KeyError:
			pass

		try:
			if row["description"]["value"] not in description:
				description.append(row["description"]["value"])
		except KeyError:
			pass

		try:
			if row["influenced"]["value"] not in influenced:
				influenced.append(row["influenced"]["value"])
		except KeyError:
			pass

		try:
			if row["influencedBy"]["value"] not in influencedBy:
				influencedBy.append(row["influencedBy"]["value"])
		except KeyError:
			pass


	dict1["vid"] = vid
	dict1["name"] = name
	dict1["birthDate"] = birthDate
	dict1["nationality"] = nationality
	dict1["genre"] = genre
	dict1["description"] = description
	dict1["influenced"] = influenced
	dict1["influencedBy"] = influencedBy

	with open("authorResult", 'a+') as fout:
		fout.write(json.dumps(dict1)+","+"\n")



f_vid.close()










