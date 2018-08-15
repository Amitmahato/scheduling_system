# your php output file
f = open('vhdl.txt', 'r')
# array of lines
routinelines = f.readlines()
#no of lines 10
print(len(routinelines))

#vhd file hera ani yo tinta kura edit gara routinelines[0] to routinelnes[8]

f = open('vgaText_top.vhd', 'r')
lines = f.readlines()
lines[91] = "		textPassageLength => %s\n" % (len(routinelines[0]))
lines[96] = '		textPassage => "%s"' % (routinelines[0])
lines[98] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[0]) - 1)

#yesari nai milau lines haru
# lines[124] = "		textPassageLength => %s\n" % (len(answer) + 7)
# lines[129] = '		textPassage => "ANSWER:%s",\n' % (answer)
# lines[131] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(answer) + 6)

lines[144] = "		textPassageLength => %s\n" % (len(routinelines[1]))
lines[149] = '		textPassage => "%s"' % (routinelines[1])
lines[151] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[1]) - 1)

lines[162] = "		textPassageLength => %s\n" % (len(routinelines[2]))
lines[167] = '		textPassage => "%s",\n' % (routinelines[2])
lines[169] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[2]) - 1)

lines[178] = "		textPassageLength => %s\n" % (len(routinelines[3]))
lines[183] = '		textPassage => "%s"' % (routinelines[3])
lines[185] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[3]) - 1)

lines[194] = "		textPassageLength => %s\n" % (len(routinelines[4]))
lines[199] = '		textPassage => "%s"' % (routinelines[4])
lines[201] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[5]) - 1)

lines[210] = "		textPassageLength => %s\n" % (len(routinelines[6]))
lines[215] = '		textPassage => "%s",\n' % (routinelines[6])
lines[217] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[6]) - 1)

lines[227] = "		textPassageLength => %s\n" % (len(routinelines[7]))
lines[232] = '		textPassage => "%s"' % (routinelines[7])
lines[234] = '		colorMap => (%s downto 0 => "111" & "111" & "11"),\n' % (len(routinelines[7]) - 1)
#rewrite the file with changes
f = open('vgaText_top.vhd', 'w')
f.writelines(lines)
f.close()
