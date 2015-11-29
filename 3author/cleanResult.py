f1 = open("goodreadsurl", "r")
f2 = open("goodreadsurl1", "w")

f2.write("[")
for line in f1.readlines():
	f2.write(line+",")

f2.write("]")
f1.close()
f2.close()