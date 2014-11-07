import csv

ifile  = open("phrases_entry.csv", "rU")
reader = csv.reader(ifile)

rownum = 0
sql = "INSERT INTO phrasicon ("
for row in reader:
    # Save header row.
    if rownum == 0:
        header = row
        colnum = 0
        for col in header:
            sql += header[colnum] + ", "
            colnum += 1
        sql = sql[:-2] + ") VALUES (\""
    else:
        colnum = 0
        for col in row:
            sql += col + "\", \"" 
            colnum += 1
        sql = sql[:-3] + ") , (\""
    rownum += 1
sql += ")\""
sql = sql[:-8] + ")"

print sql

ifile.close()
