using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using DG.Tweening;


public class ProcessControl : MonoBehaviour {

	//[SerializeField]
	List<UnitProcessBase> Process = new List<UnitProcessBase>();
	bool isRunSequence = false;

	void Awake()
	{
		Initialization();
	}
	/// <summary>
	/// 初始化
	/// </summary>
	void Initialization()
	{	
		FindUnit("Manage");
	}
	//在Manage物体上查找流程
	void FindUnit(string nameOfObj )
	{
		GameObject processObj = GameObject.Find(nameOfObj);
		MyTool.ASSERT(processObj!=null);
		for(int i =0; i< processObj.transform.childCount; i++ )
		{
			GameObject mProcessObj = processObj.transform.GetChild(i).gameObject;
			if( mProcessObj.activeSelf == false)
			{ continue; }
			UnitProcessBase uProBase = mProcessObj.GetComponent<UnitProcessBase>();
			//单体初始化
			uProBase.Initialization();
			Process.Add(uProBase);
		}
	}
	void Start () 
	{
		//Invoke("RunProcess",1);
		RunProcess();

	}
	void Update()
	{
		RunProcess();
	}

	//**************************************************************************************************
	//***********************************从此处开始处理单体流程********************************************
	/// <summary>
	/// 开始运行流程函数
	/// </summary>
	void RunProcess()
	{
		if(isRunSequence  )
		{
			return;
		}
		SetIsRunSequence(true);
		Sequence mSequence = DOTween.Sequence();
		for(int i=0; i<Process.Count; i++)
		{

			//mSequence.SetLoops(-1);
			UnitProcessBase mUnitProcess = Process[i];
			mUnitProcess.BringInSequence(mSequence);

		}
		mSequence.OnComplete(()=>SetIsRunSequence(false));
	}
	void SetIsRunSequence(bool vt)
	{
		isRunSequence = vt;
	}


}
