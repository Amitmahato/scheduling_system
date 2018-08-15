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

#include "xsi.h"

struct XSI_INFO xsi_info;

char *IEEE_P_3564397177;
char *IEEE_P_1242562249;
char *WORK_P_2892063302;
char *STD_STANDARD;
char *IEEE_P_3972351953;
char *IEEE_P_3499444699;
char *STD_TEXTIO;
char *IEEE_P_2592010699;


int main(int argc, char **argv)
{
    xsi_init_design(argc, argv);
    xsi_register_info(&xsi_info);

    xsi_register_min_prec_unit(-12);
    ieee_p_2592010699_init();
    ieee_p_3499444699_init();
    std_textio_init();
    ieee_p_3564397177_init();
    ieee_p_1242562249_init();
    ieee_p_3972351953_init();
    work_p_2892063302_init();
    work_a_3840338369_3212880686_init();
    work_a_0687322079_3212880686_init();
    work_a_0507420313_3212880686_init();
    work_a_1073688135_3212880686_init();
    work_a_1652258381_3212880686_init();
    work_a_1357104307_3212880686_init();
    work_a_3855696906_3212880686_init();
    work_a_0335020208_3212880686_init();
    work_a_2670763663_3212880686_init();
    work_a_1564398525_3212880686_init();
    work_a_1086192284_3212880686_init();
    work_a_3551646814_3212880686_init();
    work_a_3050292770_3212880686_init();
    work_a_3905810154_3212880686_init();
    work_a_3169442642_3212880686_init();
    work_a_2442449699_3212880686_init();
    work_a_3116471581_3212880686_init();
    work_a_4290181801_3212880686_init();
    work_a_1570325441_3212880686_init();
    work_a_3746693166_3212880686_init();
    work_a_1638959280_3212880686_init();
    work_a_0548418924_3212880686_init();
    work_a_0634681789_3212880686_init();


    xsi_register_tops("work_a_0634681789_3212880686");

    IEEE_P_3564397177 = xsi_get_engine_memory("ieee_p_3564397177");
    IEEE_P_1242562249 = xsi_get_engine_memory("ieee_p_1242562249");
    WORK_P_2892063302 = xsi_get_engine_memory("work_p_2892063302");
    STD_STANDARD = xsi_get_engine_memory("std_standard");
    IEEE_P_3972351953 = xsi_get_engine_memory("ieee_p_3972351953");
    IEEE_P_3499444699 = xsi_get_engine_memory("ieee_p_3499444699");
    STD_TEXTIO = xsi_get_engine_memory("std_textio");
    IEEE_P_2592010699 = xsi_get_engine_memory("ieee_p_2592010699");
    xsi_register_ieee_std_logic_1164(IEEE_P_2592010699);

    return xsi_run_simulation(argc, argv);

}
