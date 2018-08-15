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
static const char *ng0 = "E:/xampp/htdocs/tt/php/fpvga/vgaText/tb_vgaText3.vhd";
extern char *IEEE_P_2592010699;
extern char *STD_TEXTIO;
extern char *IEEE_P_3564397177;

unsigned char ieee_p_2592010699_sub_1744673427_503743352(char *, char *, unsigned int , unsigned int );
void ieee_p_3564397177_sub_1281154728_91900896(char *, char *, char *, char *, char *, unsigned char , int );
void ieee_p_3564397177_sub_1496949865_91900896(char *, char *, char *, unsigned char , unsigned char , int );


static void work_a_1550741358_2372691052_p_0(char *t0)
{
    char *t1;
    char *t2;
    char *t3;
    char *t4;
    char *t5;
    char *t6;
    int64 t7;
    int64 t8;

LAB0:    t1 = (t0 + 3608U);
    t2 = *((char **)t1);
    if (t2 == 0)
        goto LAB2;

LAB3:    goto *t2;

LAB2:    xsi_set_current_line(92, ng0);
    t2 = (t0 + 4584);
    t3 = (t2 + 56U);
    t4 = *((char **)t3);
    t5 = (t4 + 56U);
    t6 = *((char **)t5);
    *((unsigned char *)t6) = (unsigned char)2;
    xsi_driver_first_trans_fast(t2);
    xsi_set_current_line(93, ng0);
    t2 = (t0 + 2448U);
    t3 = *((char **)t2);
    t7 = *((int64 *)t3);
    t8 = (t7 / 2);
    t2 = (t0 + 3416);
    xsi_process_wait(t2, t8);

LAB6:    *((char **)t1) = &&LAB7;

LAB1:    return;
LAB4:    xsi_set_current_line(94, ng0);
    t2 = (t0 + 4584);
    t3 = (t2 + 56U);
    t4 = *((char **)t3);
    t5 = (t4 + 56U);
    t6 = *((char **)t5);
    *((unsigned char *)t6) = (unsigned char)3;
    xsi_driver_first_trans_fast(t2);
    xsi_set_current_line(95, ng0);
    t2 = (t0 + 2448U);
    t3 = *((char **)t2);
    t7 = *((int64 *)t3);
    t8 = (t7 / 2);
    t2 = (t0 + 3416);
    xsi_process_wait(t2, t8);

LAB10:    *((char **)t1) = &&LAB11;
    goto LAB1;

LAB5:    goto LAB4;

LAB7:    goto LAB5;

LAB8:    goto LAB2;

LAB9:    goto LAB8;

LAB11:    goto LAB9;

}

static void work_a_1550741358_2372691052_p_1(char *t0)
{
    char *t1;
    char *t2;
    int64 t3;
    char *t4;
    int64 t5;
    char *t6;
    char *t7;
    char *t8;

LAB0:    t1 = (t0 + 3856U);
    t2 = *((char **)t1);
    if (t2 == 0)
        goto LAB2;

LAB3:    goto *t2;

LAB2:    xsi_set_current_line(103, ng0);
    t3 = (100 * 1000LL);
    t2 = (t0 + 3664);
    xsi_process_wait(t2, t3);

LAB6:    *((char **)t1) = &&LAB7;

LAB1:    return;
LAB4:    xsi_set_current_line(105, ng0);
    t2 = (t0 + 2448U);
    t4 = *((char **)t2);
    t3 = *((int64 *)t4);
    t5 = (t3 * 10);
    t2 = (t0 + 3664);
    xsi_process_wait(t2, t5);

LAB10:    *((char **)t1) = &&LAB11;
    goto LAB1;

LAB5:    goto LAB4;

LAB7:    goto LAB5;

LAB8:    xsi_set_current_line(108, ng0);
    t2 = (t0 + 4648);
    t4 = (t2 + 56U);
    t6 = *((char **)t4);
    t7 = (t6 + 56U);
    t8 = *((char **)t7);
    *((unsigned char *)t8) = (unsigned char)3;
    xsi_driver_first_trans_fast(t2);
    xsi_set_current_line(109, ng0);
    t3 = (100 * 1000LL);
    t2 = (t0 + 3664);
    xsi_process_wait(t2, t3);

LAB14:    *((char **)t1) = &&LAB15;
    goto LAB1;

LAB9:    goto LAB8;

LAB11:    goto LAB9;

LAB12:    xsi_set_current_line(110, ng0);
    t2 = (t0 + 4648);
    t4 = (t2 + 56U);
    t6 = *((char **)t4);
    t7 = (t6 + 56U);
    t8 = *((char **)t7);
    *((unsigned char *)t8) = (unsigned char)2;
    xsi_driver_first_trans_fast(t2);
    xsi_set_current_line(113, ng0);

LAB18:    *((char **)t1) = &&LAB19;
    goto LAB1;

LAB13:    goto LAB12;

LAB15:    goto LAB13;

LAB16:    goto LAB2;

LAB17:    goto LAB16;

LAB19:    goto LAB17;

}

static void work_a_1550741358_2372691052_p_2(char *t0)
{
    char t7[16];
    char t12[8];
    char t13[8];
    char t14[8];
    char *t1;
    unsigned char t2;
    char *t3;
    char *t4;
    int64 t5;
    char *t6;
    char *t8;
    char *t9;
    int t10;
    unsigned int t11;

LAB0:    xsi_set_current_line(126, ng0);
    t1 = (t0 + 992U);
    t2 = ieee_p_2592010699_sub_1744673427_503743352(IEEE_P_2592010699, t1, 0U, 0U);
    if (t2 != 0)
        goto LAB2;

LAB4:
LAB3:    t1 = (t0 + 4424);
    *((int *)t1) = 1;

LAB1:    return;
LAB2:    xsi_set_current_line(131, ng0);
    t3 = (t0 + 3912);
    t4 = (t0 + 2952U);
    t5 = xsi_get_sim_current_time();
    std_textio_write8(STD_TEXTIO, t3, t4, t5, (unsigned char)0, 0, 1000LL);
    xsi_set_current_line(132, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 7376);
    t8 = (t7 + 0U);
    t9 = (t8 + 0U);
    *((int *)t9) = 1;
    t9 = (t8 + 4U);
    *((int *)t9) = 1;
    t9 = (t8 + 8U);
    *((int *)t9) = 1;
    t10 = (1 - 1);
    t11 = (t10 * 1);
    t11 = (t11 + 1);
    t9 = (t8 + 12U);
    *((unsigned int *)t9) = t11;
    std_textio_write7(STD_TEXTIO, t1, t3, t4, t7, (unsigned char)0, 0);
    xsi_set_current_line(136, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 7377);
    t8 = (t7 + 0U);
    t9 = (t8 + 0U);
    *((int *)t9) = 1;
    t9 = (t8 + 4U);
    *((int *)t9) = 1;
    t9 = (t8 + 8U);
    *((int *)t9) = 1;
    t10 = (1 - 1);
    t11 = (t10 * 1);
    t11 = (t11 + 1);
    t9 = (t8 + 12U);
    *((unsigned int *)t9) = t11;
    std_textio_write7(STD_TEXTIO, t1, t3, t4, t7, (unsigned char)0, 0);
    xsi_set_current_line(137, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 1512U);
    t6 = *((char **)t4);
    t2 = *((unsigned char *)t6);
    ieee_p_3564397177_sub_1496949865_91900896(IEEE_P_3564397177, t1, t3, t2, (unsigned char)0, 0);
    xsi_set_current_line(141, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 7378);
    t8 = (t7 + 0U);
    t9 = (t8 + 0U);
    *((int *)t9) = 1;
    t9 = (t8 + 4U);
    *((int *)t9) = 1;
    t9 = (t8 + 8U);
    *((int *)t9) = 1;
    t10 = (1 - 1);
    t11 = (t10 * 1);
    t11 = (t11 + 1);
    t9 = (t8 + 12U);
    *((unsigned int *)t9) = t11;
    std_textio_write7(STD_TEXTIO, t1, t3, t4, t7, (unsigned char)0, 0);
    xsi_set_current_line(142, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 1672U);
    t6 = *((char **)t4);
    t2 = *((unsigned char *)t6);
    ieee_p_3564397177_sub_1496949865_91900896(IEEE_P_3564397177, t1, t3, t2, (unsigned char)0, 0);
    xsi_set_current_line(146, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 7379);
    t8 = (t7 + 0U);
    t9 = (t8 + 0U);
    *((int *)t9) = 1;
    t9 = (t8 + 4U);
    *((int *)t9) = 1;
    t9 = (t8 + 8U);
    *((int *)t9) = 1;
    t10 = (1 - 1);
    t11 = (t10 * 1);
    t11 = (t11 + 1);
    t9 = (t8 + 12U);
    *((unsigned int *)t9) = t11;
    std_textio_write7(STD_TEXTIO, t1, t3, t4, t7, (unsigned char)0, 0);
    xsi_set_current_line(147, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 1832U);
    t6 = *((char **)t4);
    memcpy(t12, t6, 3U);
    t4 = (t0 + 7200U);
    ieee_p_3564397177_sub_1281154728_91900896(IEEE_P_3564397177, t1, t3, t12, t4, (unsigned char)0, 0);
    xsi_set_current_line(151, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 7380);
    t8 = (t7 + 0U);
    t9 = (t8 + 0U);
    *((int *)t9) = 1;
    t9 = (t8 + 4U);
    *((int *)t9) = 1;
    t9 = (t8 + 8U);
    *((int *)t9) = 1;
    t10 = (1 - 1);
    t11 = (t10 * 1);
    t11 = (t11 + 1);
    t9 = (t8 + 12U);
    *((unsigned int *)t9) = t11;
    std_textio_write7(STD_TEXTIO, t1, t3, t4, t7, (unsigned char)0, 0);
    xsi_set_current_line(152, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 1992U);
    t6 = *((char **)t4);
    memcpy(t13, t6, 3U);
    t4 = (t0 + 7216U);
    ieee_p_3564397177_sub_1281154728_91900896(IEEE_P_3564397177, t1, t3, t13, t4, (unsigned char)0, 0);
    xsi_set_current_line(156, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 7381);
    t8 = (t7 + 0U);
    t9 = (t8 + 0U);
    *((int *)t9) = 1;
    t9 = (t8 + 4U);
    *((int *)t9) = 1;
    t9 = (t8 + 8U);
    *((int *)t9) = 1;
    t10 = (1 - 1);
    t11 = (t10 * 1);
    t11 = (t11 + 1);
    t9 = (t8 + 12U);
    *((unsigned int *)t9) = t11;
    std_textio_write7(STD_TEXTIO, t1, t3, t4, t7, (unsigned char)0, 0);
    xsi_set_current_line(157, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2952U);
    t4 = (t0 + 2152U);
    t6 = *((char **)t4);
    memcpy(t14, t6, 2U);
    t4 = (t0 + 7232U);
    ieee_p_3564397177_sub_1281154728_91900896(IEEE_P_3564397177, t1, t3, t14, t4, (unsigned char)0, 0);
    xsi_set_current_line(159, ng0);
    t1 = (t0 + 3912);
    t3 = (t0 + 2776U);
    t4 = (t0 + 2952U);
    std_textio_writeline(STD_TEXTIO, t1, t3, t4);
    goto LAB3;

}


extern void work_a_1550741358_2372691052_init()
{
	static char *pe[] = {(void *)work_a_1550741358_2372691052_p_0,(void *)work_a_1550741358_2372691052_p_1,(void *)work_a_1550741358_2372691052_p_2};
	xsi_register_didat("work_a_1550741358_2372691052", "isim/tb_vgaText3_isim_beh.exe.sim/work/a_1550741358_2372691052.didat");
	xsi_register_executes(pe);
}
