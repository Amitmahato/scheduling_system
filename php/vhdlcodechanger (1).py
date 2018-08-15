# your php output file
f = open('vhdl.txt', 'r')
# array of lines
routinelines = f.readlines()
#no of lines 10
print(len(routinelines))

#vhd file hera ani yo tinta kura edit gara routinelines[0] to routinelnes[8]

f = open('E:\embedded\FP-V-GA-Text-master\vgaText\vgaText_top.vhd', 'r')
lines = f.readlines()
lines[92] = "		textPassageLength => %s\n" % (len(routinelines[0]))
lines[97] = '		textPassage => "%s",\n' % (routinelines[0])
lines[99] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[0]) - 1)

#yesari nai milau lines haru
# lines[124] = "		textPassageLength => %s\n" % (len(answer) + 7)
# lines[129] = '		textPassage => "ANSWER:%s",\n' % (answer)
# lines[131] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(answer) + 6)
f.close()

#rewrite the file with changes
f = open('vgaText_top.vhd', 'w')
f.writelines(lines)
f.close()
