/**********************************************************************/
/*   ____  ____                                                       */
/*  /   /\/   /                                                       */
/* /___/  \  /                                                        */
/* \   \   \/                                                       */
/*  \   \        Copyright (c) 2003-2009 Xilinx, Inc.                */
/*  /   /          All Right Reserved.                                 */
/* /---/   /\                                                         */
/* \   \  /  \                                                      */
/*  \___\/\___\                                                    */
/***********************************************************************/

/* This file is designed for use with ISim build 0x7708f090 */

#define XSI_HIDE_SYMBOL_SPEC true
#include "xsi.h"
#include <memory.h>
#ifdef __GNUC__
#include <stdlib.h>
#else
#include <malloc.h>
#define alloca _alloca
#endif
extern char *IEEE_P_3972351953;

double ieee_p_3972351953_sub_1147618771_2984157535(char *, double );
double ieee_p_3972351953_sub_528838134_2984157535(char *, double );


int work_p_2892063302_sub_3737532971_3757376413(char *t1, int t2)
{
    char t4[8];
    int t0;
    char *t5;
    double t6;
    double t7;
    int t8;
    unsigned char t9;
    unsigned char t10;
    double t11;
    double t12;

LAB0:    t5 = (t4 + 4U);
    *((int *)t5) = t2;
    t6 = ieee_p_3972351953_sub_528838134_2984157535(IEEE_P_3972351953, ((double)(t2)));
    t7 = ieee_p_3972351953_sub_1147618771_2984157535(IEEE_P_3972351953, t6);
    t9 = (t7 >= 0);
    if (t9 == 1)
        goto LAB2;

LAB3:    t12 = (t7 - 0.50000000000000000);
    t8 = ((int)(t12));

LAB4:    t0 = t8;

LAB1:    return t0;
LAB2:    t10 = (t7 >= 2147483647);
    if (t10 == 1)
        goto LAB5;

LAB6:    t11 = (t7 + 0.50000000000000000);
    t8 = ((int)(t11));
    goto LAB4;

LAB5:    t8 = 2147483647;
    goto LAB4;

LAB7:;
}


extern void work_p_2892063302_init()
{
	static char *se[] = {(void *)work_p_2892063302_sub_3737532971_3757376413};
	xsi_register_didat("work_p_2892063302", "isim/tb_vgaText3_isim_beh.exe.sim/work/p_2892063302.didat");
	xsi_register_subprogram_executes(se);
}
