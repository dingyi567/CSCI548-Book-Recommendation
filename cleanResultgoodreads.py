f1 = open("goodreads.json", "r")
f2 = open("goodreadsclean.json", "w")

f2.write("[")
for line in f1.readlines():
	if line[0]=='}':
		f2.write(line)
		f2.write(",\n")
	else:
		f2.write(line)


f2.write("]")
f1.close()
f2.close()

f1 = open("goodreadsauthor.json", "r")
f2 = open("goodreadsauthorclean.json", "w")

f2.write("[")
for line in f1.readlines():
	if line[0]=='}':
		f2.write(line)
		f2.write(",\n")
	else:
		f2.write(line)


f2.write("]")
f1.close()
f2.close()