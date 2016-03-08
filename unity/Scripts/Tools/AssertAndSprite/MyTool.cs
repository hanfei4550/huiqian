using UnityEngine;
using System.Collections;

public class MyTool : MonoBehaviour {
	//断言
	public static void ASSERT( bool assertBool,string warn)
	{
		if(assertBool==false)
		{
			Debug.LogError("ASSERT(断言) !"+warn);
		}
	}
	public static void ASSERT( bool assertBool)
	{
		if(assertBool==false)
		{
			Debug.LogError("ASSERT(断言) !");
		}
	}

}
