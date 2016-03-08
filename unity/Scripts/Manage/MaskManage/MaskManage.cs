using UnityEngine;
using System.Collections;
using System.Collections.Generic;
public class MaskManage : MonoBehaviour {
	[SerializeField]
	List<MaskInfo> maskInfoList = new List<MaskInfo>();
	void Awake()
	{
		GameObject manage = GameObject.Find("Manage");
		MyTool.ASSERT(manage!=null);
		manage.BroadcastMessage("SetMaskInfoList",maskInfoList);
	}
}
[System.Serializable]
public class MaskInfo
{
	public MaskType maskType = MaskType.Non;
	public Texture2D mask = null;
}